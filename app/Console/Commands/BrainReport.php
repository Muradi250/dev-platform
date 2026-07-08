<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BrainReport extends Command
{
    protected $signature = 'brain:report';
    protected $description = 'Generate brain-report.json and a static HTML dashboard';

    public function handle()
    {
        $path = storage_path('app/brain.json');

        if (! File::exists($path)) {
            $this->error("Brain file not found at {$path}");
            return 1;
        }

        $brain = json_decode(File::get($path), true);

        if (! is_array($brain)) {
            $this->error('Invalid brain.json format');
            return 1;
        }

        $this->info('Computing roadmap progress...');

        $totalPhases = 0;
        $completed = 0;

        foreach ($brain['roadmap'] as $key => $phase) {
            $totalPhases++;
            if (($phase['status'] ?? null) === 'done') {
                $completed += 1;
            }
            if (($phase['status'] ?? null) === 'in_progress') {
                $completed += 0.5;
            }
        }

        $progress = $totalPhases > 0 ? intval(($completed / $totalPhases) * 100) : 0;

        // Extended analysis
        $this->info('Running extended analysis...');

        $scanPaths = [
            base_path('app'),
            resource_path('views'),
            base_path('database/migrations'),
            base_path('routes'),
            base_path('tests'),
        ];

        $analysis = [
            'paths' => [],
            'total_files' => 0,
            'total_lines' => 0,
            'recent_files' => [],
        ];

        foreach ($scanPaths as $p) {
            if (! File::exists($p)) {
                continue;
            }

            $files = File::allFiles($p);
            $count = count($files);
            $lines = 0;

            foreach ($files as $f) {
                $content = File::get($f->getRealPath());
                $lines += substr_count($content, "\n") + 1;
                $analysis['recent_files'][] = [
                    'path' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $f->getRealPath()),
                    'modified' => date('c', $f->getMTime()),
                ];
            }

            $analysis['paths'][str_replace(base_path() . DIRECTORY_SEPARATOR, '', $p)] = [
                'files' => $count,
                'lines' => $lines,
            ];

            $analysis['total_files'] += $count;
            $analysis['total_lines'] += $lines;
        }

        usort($analysis['recent_files'], function ($a, $b) {
            return strcmp($b['modified'], $a['modified']);
        });
        $analysis['recent_files'] = array_slice($analysis['recent_files'], 0, 20);

        $report = [
            'brain' => $brain,
            'analysis' => $analysis,
            'progress' => $progress,
            'generated_at' => now()->toDateTimeString(),
        ];

        $reportPath = storage_path('app/brain-report.json');
        File::put($reportPath, json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info("JSON report written: {$reportPath}");

        $html = $this->generateHtmlDashboard($report);
        $publicPath = public_path('brain-dashboard.html');
        File::put($publicPath, $html);
        $this->info("Dashboard generated: {$publicPath}");

        return 0;
    }

    protected function generateHtmlDashboard(array $report): string
    {
        $brain = $report['brain'];
        $analysis = $report['analysis'];
        $title = htmlspecialchars($brain['project'] ?? 'Dev Platform', ENT_QUOTES, 'UTF-8');
        $generated = htmlspecialchars($report['generated_at'], ENT_QUOTES, 'UTF-8');
        $progress = $report['progress'] ?? 0;

        $phaseCards = '';
        foreach ($brain['roadmap'] as $key => $phase) {
            $status = $phase['status'] ?? 'not_started';
            $label = match ($status) {
                'done' => 'Done',
                'in_progress' => 'In Progress',
                'future' => 'Future',
                default => 'Not Started',
            };
            $progressValue = $phase['progress'] ?? ($status === 'done' ? 100 : ($status === 'in_progress' ? 32 : 4));
            $badgeClass = match ($status) {
                'done' => 'badge-done',
                'in_progress' => 'badge-progress',
                'future' => 'badge-future',
                default => 'badge-pending',
            };

            $featureList = '';
            if (! empty($phase['features']) && is_array($phase['features'])) {
                foreach ($phase['features'] as $feature) {
                    $featureList .= '<li>' . htmlspecialchars($feature, ENT_QUOTES, 'UTF-8') . '</li>';
                }
            }

            $result = isset($phase['result']) ? '<p class="phase-result">🎯 ' . htmlspecialchars($phase['result'], ENT_QUOTES, 'UTF-8') . '</p>' : '';

            $phaseCards .= "<article class=\"phase-card\"><div class=\"phase-header\"><h3>" . htmlspecialchars($phase['title'] ?? $key, ENT_QUOTES, 'UTF-8') . "</h3><span class=\"badge {$badgeClass}\">{$label}</span></div><div class=\"phase-progress\"><div class=\"phase-track\"><div class=\"phase-fill\" style=\"width:{$progressValue}%\"></div></div><span>{$progressValue}%</span></div>{$result}";
            if ($featureList !== '') {
                $phaseCards .= "<div class=\"phase-features\"><strong>Features</strong><ul>{$featureList}</ul></div>";
            }
            $phaseCards .= '</article>';
        }

        $bucketRows = '';
        foreach ($analysis['paths'] as $p => $meta) {
            $width = $analysis['total_files'] > 0 ? intval(($meta['files'] / $analysis['total_files']) * 100) : 0;
            $bucketRows .= "<div class=\"bucket-row\"><span>" . htmlspecialchars($p, ENT_QUOTES, 'UTF-8') . "</span><div class=\"bucket-track\"><div class=\"bucket-fill\" style=\"width:{$width}%\"></div></div><span>" . intval($meta['files']) . " files</span></div>";
        }

        $recentRows = '';
        foreach ($analysis['recent_files'] as $f) {
            $recentRows .= "<li><strong>" . htmlspecialchars($f['path'], ENT_QUOTES, 'UTF-8') . "</strong><span>" . htmlspecialchars($f['modified'], ENT_QUOTES, 'UTF-8') . "</span></li>";
        }

        $phasesCount = count($brain['roadmap'] ?? []);

        $html = <<<HTML
<!doctype html>
<html lang="fa">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{$title} — Brain Dashboard</title>
  <style>
    :root {
      color-scheme: dark;
      background: #040a13;
      color: #eef3ff;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    * { box-sizing: border-box; }
    body { margin: 0; min-height: 100vh; background: radial-gradient(circle at top right, rgba(63, 171, 255, .18), transparent 24%), linear-gradient(180deg, #07121f 0%, #02060d 100%); }
    .page { width: min(1200px, 100%); margin: 0 auto; padding: 28px 22px 40px; }
    .hero { display: grid; grid-template-columns: minmax(0, 1.5fr) 380px; gap: 24px; align-items: center; margin-bottom: 34px; }
    .hero-badge { display: inline-flex; align-items: center; gap: 10px; padding: 12px 18px; border-radius: 999px; border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.06); color: #c7dfff; font-size: .95rem; }
    .hero-title { margin: 18px 0 0; font-size: clamp(2.8rem, 4vw, 4.8rem); line-height: 0.95; letter-spacing: -0.06em; }
    .hero-text { margin: 20px 0 0; color: #b3c7e2; font-size: 1rem; line-height: 1.8; max-width: 680px; }
    .hero-panel { border-radius: 32px; border: 1px solid rgba(255,255,255,.08); background: rgba(15, 30, 48, .95); padding: 32px; box-shadow: 0 30px 90px rgba(0,0,0,.24); }
    .hero-panel h2 { margin: 0 0 20px; color: #98cfff; font-size: 1.05rem; }
    .meter-ring { width: 210px; height: 210px; margin: 0 auto 18px; border-radius: 50%; background: conic-gradient(#5fd5ff {$progress}%, rgba(255,255,255,.08) 0); display: grid; place-items: center; position: relative; }
    .meter-ring::before { content: ''; width: 150px; height: 150px; border-radius: 50%; background: #040a13; position: absolute; }
    .meter-ring strong { position: relative; font-size: 2.8rem; color: #fff; }
    .hero-panel p { margin: 0; color: #92adc6; text-align: center; }
    .stats { display: grid; gap: 16px; grid-template-columns: repeat(3, minmax(0, 1fr)); margin-top: 28px; }
    .stat-card { border-radius: 24px; padding: 22px 24px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); display: grid; gap: 10px; }
    .stat-card small { color: #8cadd2; text-transform: uppercase; letter-spacing: .08em; }
    .stat-card strong { font-size: 2.1rem; color: #fff; }
    .main { display: grid; gap: 24px; grid-template-columns: 2fr 1fr; }
    .panel { border-radius: 28px; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); padding: 28px; }
    .panel h2 { margin: 0 0 20px; color: #e9f4ff; }
    .roadmap-grid { display: grid; gap: 20px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
    .phase-card { border-radius: 24px; border: 1px solid rgba(255,255,255,.08); background: rgba(255,255,255,.03); padding: 24px; display: grid; gap: 18px; }
    .phase-header { display: flex; justify-content: space-between; gap: 12px; align-items: flex-start; }
    .phase-header h3 { margin: 0; color: #fff; font-size: 1rem; }
    .badge { padding: 8px 14px; border-radius: 999px; font-size: .78rem; text-transform: uppercase; letter-spacing: .08em; }
    .badge-done { background: rgba(96, 224, 169, .18); color: #b8ffdc; }
    .badge-progress { background: rgba(111, 176, 255, .15); color: #b9d8ff; }
    .badge-future { background: rgba(145, 154, 255, .15); color: #d7dcff; }
    .badge-pending { background: rgba(255, 176, 106, .16); color: #ffd6a4; }
    .phase-line { display: grid; gap: 10px; }
    .phase-track { width: 100%; height: 12px; border-radius: 999px; background: rgba(255,255,255,.06); overflow: hidden; }
    .phase-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #7dc8ff, #4a8dff); }
    .phase-meta { display: flex; justify-content: space-between; color: #a8c3db; font-size: .9rem; }
    .phase-features { margin: 0; padding-left: 18px; color: #dbe7ff; }
    .phase-features li { margin-bottom: 8px; }
    .phase-result { margin: 0; color: #b9f0ff; }
    .bucket-row { display: grid; grid-template-columns: auto 1fr auto; gap: 14px; align-items: center; margin-bottom: 18px; }
    .bucket-text { color: #bed6f4; font-size: .95rem; }
    .bucket-track { height: 12px; background: rgba(255,255,255,.06); border-radius: 999px; overflow: hidden; }
    .bucket-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, #6ee0ff, #3b7cff); }
    .bucket-count { color: #9fb7d4; font-size: .92rem; white-space: nowrap; }
    .recent-items { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
    .recent-items li { padding: 18px 20px; border-radius: 20px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); display: grid; gap: 8px; }
    .recent-items strong { color: #f6fbff; }
    .recent-items span { color: #93adc7; font-size: .9rem; }
    .note { color: #92b0d8; margin-top: 28px; font-size: .95rem; }
    .footer { margin-top: 26px; color: #7d95b5; font-size: .95rem; }
    @media (max-width: 980px) { .hero, .main { grid-template-columns: 1fr; } .stats { grid-template-columns: 1fr; } }
  </style>
</head>
<body>
  <div class="page">
    <div class="hero">
      <div>
        <div class="hero-badge">🧠 داشبورد ذهن پروژه</div>
        <h1 class="hero-title">Dev Platform Brain</h1>
        <p class="hero-text">یک داشبورد حرفه‌ای با طراحی مدرن برای نمایش پیشرفت پروژه، وضعیت فازها و تحلیل کدبیس.</p>
        <div class="stats">
          <div class="stat-card"><small>فازها</small><strong>{$phasesCount}</strong></div>
          <div class="stat-card"><small>فایل‌ها</small><strong>{$analysis['total_files']}</strong></div>
          <div class="stat-card"><small>سطرها</small><strong>{$analysis['total_lines']}</strong></div>
        </div>
      </div>
      <div class="hero-panel">
        <h2>پیشرفت کلی</h2>
        <div class="meter-ring"><strong>{$progress}%</strong></div>
        <p>آخرین بروزرسانی: {$generated}</p>
      </div>
    </div>

    <div class="main">
      <section class="panel">
        <h2>Roadmap Status</h2>
        <div class="roadmap-grid">
          {$phaseCards}
        </div>
      </section>

      <section class="panel">
        <h2>Dashboard Insights</h2>
        <div class="bucket-row">
          <div class="bucket-text">File distribution</div>
          <div class="bucket-track"><div class="bucket-fill" style="width: 100%"></div></div>
          <span>{$analysis['total_files']} files</span>
        </div>
        {$bucketRows}

        <h3 style="margin-top: 24px; color: #dbe7ff;">Recent file changes</h3>
        <ul class="recent-items">
          {$recentRows}
        </ul>

        <p class="note">این صفحه از فایل brain.json و تحلیل کدبیس به صورت خودکار ساخته شده است.</p>
      </section>
    </div>

    <div class="footer">Generated on {$generated} · View <a href="/brain" style="color:#7dc8ff; text-decoration:none;">/brain</a></div>
  </div>
</body>
</html>
HTML;

        return $html;
    }
}
