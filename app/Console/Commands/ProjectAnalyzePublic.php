<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class ProjectAnalyzePublic extends Command
{
    protected $signature = 'project:analyze-public
                            {--all : Analyze all Blade views instead of only public-site views}
                            {--deep : Perform deep content and architecture analysis}
                            {--duplicates : Analyze possible duplicate files}
                            {--risks : Analyze CSS, stacking and positioning risks}
                            {--references : Analyze Blade references in detail}
                            {--json : Output analysis as JSON}
                            {--no-summary : Hide final summary}';

    protected $description = 'Professional deep analysis of Laravel public Blade architecture, Page Builder, blocks, references, duplicates and risks.';

    private string $viewsPath;
    private string $publicPath;
    private string $layoutsPath;

    private array $stats = [
        'files' => 0,
        'public_files' => 0,
        'layout_files' => 0,
        'block_files' => 0,
        'page_builder_files' => 0,
        'references' => 0,
        'broken_references' => 0,
        'dynamic_references' => 0,
        'warnings' => 0,
        'errors' => 0,
        'info_messages' => 0,
        'risk_matches' => 0,
        'duplicate_groups' => 0,
    ];

    private array $warnings = [];
    private array $errors = [];
    private array $infos = [];
    private array $brokenReferences = [];
    private array $dynamicReferences = [];
    private array $riskMatches = [];

    public function handle(): int
    {
        $this->viewsPath = resource_path('views');
        $this->publicPath = resource_path('views/public');
        $this->layoutsPath = resource_path('views/layouts');

        if (!File::isDirectory($this->viewsPath)) {
            $this->error('resources/views directory was not found.');
            return self::FAILURE;
        }

        if (!File::isDirectory($this->publicPath)) {
            $this->error('resources/views/public directory was not found.');
            return self::FAILURE;
        }

        try {
            $allViews = $this->bladeFiles($this->viewsPath);
            $publicViews = $this->bladeFiles($this->publicPath);
            $layoutViews = $this->bladeFiles($this->layoutsPath);

            $blockPath = $this->publicPath . DIRECTORY_SEPARATOR . 'blocks';
            $pageBuilderPath = $this->publicPath . DIRECTORY_SEPARATOR . 'page-builder';

            $blockViews = $this->bladeFiles($blockPath);
            $pageBuilderViews = $this->bladeFiles($pageBuilderPath);

            $this->stats['files'] = count($allViews);
            $this->stats['public_files'] = count($publicViews);
            $this->stats['layout_files'] = count($layoutViews);
            $this->stats['block_files'] = count($blockViews);
            $this->stats['page_builder_files'] = count($pageBuilderViews);

            if ($this->option('json')) {
                $this->runAnalysis(
                    $allViews,
                    $publicViews,
                    $layoutViews,
                    $blockViews,
                    $pageBuilderViews,
                    $blockPath,
                    $pageBuilderPath,
                    false
                );

                $this->outputJson();

                return $this->hasCriticalProblems()
                    ? self::FAILURE
                    : self::SUCCESS;
            }

            $this->header();

            $this->runAnalysis(
                $allViews,
                $publicViews,
                $layoutViews,
                $blockViews,
                $pageBuilderViews,
                $blockPath,
                $pageBuilderPath,
                true
            );

            if (!$this->option('no-summary')) {
                $this->finalSummary();
            }

            return $this->hasCriticalProblems()
                ? self::FAILURE
                : self::SUCCESS;
        } catch (Throwable $e) {
            $this->error('Analysis failed.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    private function runAnalysis(
        array $allViews,
        array $publicViews,
        array $layoutViews,
        array $blockViews,
        array $pageBuilderViews,
        string $blockPath,
        string $pageBuilderPath,
        bool $terminal
    ): void {
        $this->projectSummary();

        $this->publicStructure();

        $this->importantFiles();

        $this->specialFiles($allViews);

        $this->blockInventory($blockViews);

        $this->pageBuilderInventory($pageBuilderPath);

        $this->entryPoints();

        if (
            $this->option('deep') ||
            $this->option('references')
        ) {
            $this->analyzeReferences(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );
        }

        if ($this->option('deep')) {
            $this->analyzeBrokenReferences(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );

            $this->analyzeUnusedPublicViews(
                $allViews,
                $publicViews
            );

            $this->analyzeBladeStructure(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );

            $this->analyzeAssets(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );

            $this->analyzeBlockReferences(
                $blockViews,
                $publicViews
            );
        }

        if ($this->option('duplicates')) {
            $this->analyzeDuplicates(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );
        }

        if ($this->option('risks')) {
            $this->analyzeRisks(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );
        }

        if ($this->option('deep')) {
            $this->analyzeDynamicViews(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );

            $this->analyzeHeaderNavigationFooter();

            $this->architectureCheck();

            $this->analyzeCommonProblems(
                $this->option('all')
                    ? $allViews
                    : $publicViews
            );
        }
    }

    private function projectSummary(): void
    {
        $this->section('PROJECT SUMMARY');

        $this->line('Laravel Views       : ' . $this->stats['files']);
        $this->line('Public Views        : ' . $this->stats['public_files']);
        $this->line('Layout Views        : ' . $this->stats['layout_files']);
        $this->line('Page Builder Views  : ' . $this->stats['page_builder_files']);
        $this->line('Block Views         : ' . $this->stats['block_files']);
    }

    private function publicStructure(): void
    {
        $this->section('PUBLIC SITE STRUCTURE');

        $blockPath = $this->publicPath . DIRECTORY_SEPARATOR . 'blocks';
        $pageBuilderPath = $this->publicPath . DIRECTORY_SEPARATOR . 'page-builder';

        $structure = [
            'Public root' => $this->publicPath,
            'Blocks' => $blockPath,
            'Page Builder' => $pageBuilderPath,
            'Layouts' => $this->layoutsPath,
        ];

        foreach ($structure as $name => $path) {
            if (File::isDirectory($path)) {
                $this->successLine($name . ' : FOUND');
            } else {
                $this->warningLine($name . ' : NOT FOUND');
            }
        }
    }

    private function importantFiles(): void
    {
        $this->section('IMPORTANT PUBLIC FILES');

        $files = [
            'layouts/public.blade.php',
            'public/home.blade.php',
            'public/page.blade.php',

            'public/partials/navbar.blade.php',
            'public/partials/footer.blade.php',

            'public/page-builder/Header/header.blade.php',
            'public/page-builder/Navigation/navigation.blade.php',
            'public/page-builder/Footer/footer.blade.php',
        ];

        foreach ($files as $relative) {
            if (File::exists($this->absoluteViewPath($relative))) {
                $this->successLine('FOUND  ' . $relative);
            } else {
                $this->warningLine('MISSING ' . $relative);

                $this->addWarning(
                    'Missing important public file: ' . $relative
                );
            }
        }
    }

    private function specialFiles(array $files): void
    {
        $this->section('HEADER / NAVIGATION / FOOTER');

        $special = [];

        foreach ($files as $file) {
            $name = strtolower($file->getFilename());

            if (
                str_contains($name, 'header') ||
                str_contains($name, 'navbar') ||
                str_contains($name, 'navigation') ||
                str_contains($name, 'footer')
            ) {
                $special[] = $file;
            }
        }

        if (empty($special)) {
            $this->dimLine(
                'No Header / Navbar / Navigation / Footer files found.'
            );

            return;
        }

        foreach ($special as $file) {
            $this->line(
                '  ' . $this->relative(
                    $file->getPathname(),
                    $this->viewsPath
                )
            );
        }
    }

    private function blockInventory(array $blockViews): void
    {
        $this->section('PAGE BUILDER BLOCKS');

        if (empty($blockViews)) {
            $this->warningLine('No public block views found.');

            $this->addWarning('No public block Blade files were found.');

            return;
        }

        foreach ($blockViews as $file) {
            $name = pathinfo(
                $file->getFilename(),
                PATHINFO_FILENAME
            );

            $this->successLine(
                sprintf(
                    '%-25s %s',
                    $name,
                    $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    )
                )
            );
        }
    }

    private function pageBuilderInventory(string $pageBuilderPath): void
    {
        $this->section('PAGE BUILDER SECTIONS');

        if (!File::isDirectory($pageBuilderPath)) {
            $this->warningLine(
                'Page Builder directory not found.'
            );

            return;
        }

        $directories = File::directories($pageBuilderPath);

        if (empty($directories)) {
            $this->warningLine(
                'No Page Builder sections found.'
            );

            return;
        }

        foreach ($directories as $directory) {
            $files = $this->bladeFiles($directory);

            $this->line(sprintf(
                '%-30s %d Blade file(s)',
                basename($directory),
                count($files)
            ));

            foreach ($files as $file) {
                $this->line(
                    '   └─ ' .
                    $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    )
                );
            }
        }
    }

    private function entryPoints(): void
    {
        $this->section('PUBLIC ENTRY POINTS');

        $entryPoints = [
            'public/home.blade.php',
            'public/page.blade.php',
            'layouts/public.blade.php',
        ];

        foreach ($entryPoints as $relative) {
            $path = $this->absoluteViewPath($relative);

            if (!File::exists($path)) {
                continue;
            }

            $this->line('');
            $this->line(
                '<fg=yellow;options=bold>' .
                $relative .
                '</>'
            );

            $content = File::get($path);
            $references = $this->extractReferences($content);

            if (empty($references)) {
                $this->dimLine(
                    '  No static Blade references detected.'
                );

                continue;
            }

            foreach ($references as $reference) {
                $this->line('  └─ ' . $reference);
            }
        }
    }

    private function analyzeReferences(array $files): void
    {
        $this->section('BLADE INCLUDE / EXTENDS REFERENCES');

        $found = false;

        foreach ($files as $file) {
            $content = File::get($file->getPathname());
            $references = $this->extractReferences($content);

            if (empty($references)) {
                continue;
            }

            $found = true;

            $this->line('');
            $this->line(
                '<fg=yellow;options=bold>' .
                $this->relative(
                    $file->getPathname(),
                    $this->viewsPath
                ) .
                '</>'
            );

            foreach ($references as $reference) {
                $this->line('  └─ ' . $reference);
                $this->stats['references']++;
            }
        }

        if (!$found) {
            $this->dimLine('No static references found.');
        }
    }

    private function extractReferences(string $content): array
    {
        $references = [];

        $directives = [
            '@extends',
            '@include',
            '@includeIf',
            '@includeWhen',
            '@includeUnless',
            '@each',
            '@component',
        ];

        foreach ($directives as $directive) {
            $pattern =
                '/' .
                preg_quote($directive, '/') .
                '\s*\(\s*[\'"]([^\'"]+)[\'"]/';

            if (
                preg_match_all(
                    $pattern,
                    $content,
                    $matches
                )
            ) {
                foreach ($matches[1] as $target) {
                    $references[] =
                        $directive .
                        "('" .
                        $target .
                        "')";
                }
            }
        }

        return array_values(
            array_unique($references)
        );
    }

    private function analyzeBrokenReferences(array $files): void
    {
        $this->section('BROKEN BLADE REFERENCES');

        $found = false;

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            $references = $this->extractReferenceTargets(
                $content
            );

            foreach ($references as $reference) {
                if (
                    $this->isDynamicReference(
                        $reference['target']
                    )
                ) {
                    continue;
                }

                if (
                    !$this->viewExists(
                        $reference['target']
                    )
                ) {
                    $found = true;

                    $relative = $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    );

                    $message =
                        $relative .
                        ':' .
                        $reference['line'] .
                        ' -> ' .
                        $reference['directive'] .
                        "('" .
                        $reference['target'] .
                        "')";

                    $this->warningLine(
                        $message
                    );

                    $this->stats['broken_references']++;

                    $this->brokenReferences[] = [
                        'file' => $relative,
                        'line' => $reference['line'],
                        'directive' => $reference['directive'],
                        'target' => $reference['target'],
                    ];
                }
            }
        }

        if (!$found) {
            $this->successLine(
                'No broken static Blade references detected.'
            );
        }
    }

    private function extractReferenceTargets(string $content): array
    {
        $results = [];

        $directives = [
            '@extends',
            '@include',
            '@includeIf',
            '@includeWhen',
            '@includeUnless',
            '@each',
            '@component',
        ];

        $lines = preg_split(
            '/\R/',
            $content
        );

        foreach ($lines as $number => $line) {
            foreach ($directives as $directive) {
                $pattern =
                    '/' .
                    preg_quote($directive, '/') .
                    '\s*\(\s*[\'"]([^\'"]+)[\'"]/';

                if (
                    preg_match_all(
                        $pattern,
                        $line,
                        $matches
                    )
                ) {
                    foreach ($matches[1] as $target) {
                        $results[] = [
                            'directive' => $directive,
                            'target' => $target,
                            'line' => $number + 1,
                        ];
                    }
                }
            }
        }

        return $results;
    }

    private function viewExists(string $view): bool
    {
        $view = trim($view);

        if ($view === '') {
            return false;
        }

        $relative = str_replace(
            '.',
            DIRECTORY_SEPARATOR,
            $view
        );

        $path =
            $this->viewsPath .
            DIRECTORY_SEPARATOR .
            $relative .
            '.blade.php';

        return File::exists($path);
    }

    private function isDynamicReference(string $reference): bool
    {
        return
            str_contains($reference, '$') ||
            str_contains($reference, '{{') ||
            str_contains($reference, '}}') ||
            str_contains($reference, '(') ||
            str_contains($reference, ')') ||
            str_contains($reference, '[') ||
            str_contains($reference, ']');
    }

    private function analyzeUnusedPublicViews(
        array $allViews,
        array $publicViews
    ): void {
        $this->section('POSSIBLY UNUSED PUBLIC VIEWS');

        $referenced = [];

        foreach ($allViews as $file) {
            $content = File::get($file->getPathname());

            foreach (
                $this->extractReferenceTargets($content)
                as $reference
            ) {
                if (
                    !$this->isDynamicReference(
                        $reference['target']
                    )
                ) {
                    $referenced[
                        $reference['target']
                    ] = true;
                }
            }
        }

        $unused = [];

        foreach ($publicViews as $file) {
            $relative = $this->relative(
                $file->getPathname(),
                $this->viewsPath
            );

            $viewName = str_replace(
                ['/', '\\'],
                '.',
                preg_replace(
                    '/\.blade\.php$/',
                    '',
                    $relative
                )
            );

            if (
                isset($referenced[$viewName])
            ) {
                continue;
            }

            if (
                in_array(
                    $viewName,
                    [
                        'public.home',
                        'public.page',
                    ],
                    true
                )
            ) {
                continue;
            }

            $unused[] = $viewName;
        }

        if (empty($unused)) {
            $this->successLine(
                'No obviously unused public views detected.'
            );

            return;
        }

        foreach ($unused as $view) {
            $this->warningLine(
                'Possibly unused: ' . $view
            );
        }

        $this->addInfo(
            'Unused detection is advisory. Dynamic view loading can make a file appear unused.'
        );
    }

    private function analyzeBladeStructure(array $files): void
    {
        $this->section('BLADE STRUCTURE ANALYSIS');

        $found = false;

        foreach ($files as $file) {
            $content = File::get($file->getPathname());
            $relative = $this->relative(
                $file->getPathname(),
                $this->viewsPath
            );

            $extendsCount = preg_match_all(
                '/@extends\s*\(/',
                $content
            );

            if ($extendsCount > 1) {
                $found = true;

                $this->warningLine(
                    $relative .
                    ' contains multiple @extends directives.'
                );

                $this->addWarning(
                    $relative .
                    ' contains multiple @extends directives.'
                );
            }

            if (
                str_contains($content, '@yield(') &&
                !str_contains($content, '@section(')
            ) {
                $found = true;

                $this->warningLine(
                    $relative .
                    ' contains @yield but no @section.'
                );
            }

            if (
                str_contains($content, '@stack(') &&
                !str_contains($content, '@push(') &&
                !str_contains($content, '@pushOnce(')
            ) {
                $this->addInfo(
                    $relative .
                    ' uses @stack without a local @push. Check parent layouts.'
                );
            }
        }

        if (!$found) {
            $this->successLine(
                'No obvious Blade structure problems detected.'
            );
        }
    }

    private function analyzeAssets(array $files): void
    {
        $this->section('ASSET / VITE ANALYSIS');

        $viteFound = false;
        $assetFound = false;

        foreach ($files as $file) {
            $content = File::get($file->getPathname());

            if (str_contains($content, '@vite(')) {
                $viteFound = true;
            }

            if (
                str_contains($content, 'asset(') ||
                str_contains($content, 'Storage::url') ||
                str_contains($content, 'storage/')
            ) {
                $assetFound = true;
            }
        }

        if ($viteFound) {
            $this->successLine(
                'Vite references detected.'
            );
        } else {
            $this->warningLine(
                'No @vite references detected in analyzed views.'
            );
        }

        if ($assetFound) {
            $this->infoLine(
                'Asset / Storage references detected.'
            );
        }
    }

    private function analyzeBlockReferences(
        array $blockViews,
        array $publicViews
    ): void {
        $this->section('BLOCK REFERENCE ANALYSIS');

        if (empty($blockViews)) {
            $this->warningLine(
                'No blocks available for reference analysis.'
            );

            return;
        }

        $blockNames = [];

        foreach ($blockViews as $file) {
            $blockNames[] = pathinfo(
                $file->getFilename(),
                PATHINFO_FILENAME
            );
        }

        $foundDynamicBlockLoader = false;

        foreach ($publicViews as $file) {
            $content = File::get(
                $file->getPathname()
            );

            if (
                str_contains(
                    $content,
                    'public.blocks.'
                ) ||
                str_contains(
                    $content,
                    "public.blocks/"
                )
            ) {
                $foundDynamicBlockLoader = true;

                $this->successLine(
                    $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    ) .
                    ' appears to load public blocks dynamically.'
                );
            }
        }

        if (!$foundDynamicBlockLoader) {
            $this->warningLine(
                'No obvious dynamic public block loader detected.'
            );

            $this->addWarning(
                'Page Builder blocks may not be connected to the public renderer.'
            );
        }

        $this->line('');
        $this->line(
            'Registered public block files: ' .
            count($blockNames)
        );
    }

    private function analyzeDuplicates(array $files): void
    {
        $this->section('POSSIBLE DUPLICATES');

        $groups = [];

        foreach ($files as $file) {
            $filename = strtolower(
                $file->getFilename()
            );

            $normalized = preg_replace(
                '/\.blade\.php$/',
                '',
                $filename
            );

            $normalized = preg_replace(
                '/[-_]/',
                '',
                $normalized
            );

            $groups[$normalized][] = $file;
        }

        $found = false;

        foreach ($groups as $name => $group) {
            if (count($group) < 2) {
                continue;
            }

            $found = true;
            $this->stats['duplicate_groups']++;

            $this->line(
                '<fg=red;options=bold>[CHECK] ' .
                strtoupper($name) .
                '</>'
            );

            foreach ($group as $file) {
                $this->line(
                    '  - ' .
                    $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    )
                );
            }

            $this->warningLine(
                '  Similar filenames detected. Check references and functionality before deleting anything.'
            );
        }

        if (!$found) {
            $this->successLine(
                'No duplicate filename groups detected.'
            );
        }
    }

    private function analyzeRisks(array $files): void
    {
        $this->section(
            'STACKING / CSS / POSITIONING RISKS'
        );

        $patterns = [
            'z-' => 'Tailwind z-index',
            'z[' => 'Arbitrary z-index',
            'z-[999' => 'Very high z-index',
            'sticky' => 'Sticky positioning',
            'fixed' => 'Fixed positioning',
            'absolute' => 'Absolute positioning',
            'transform' => 'Transform',
            'backdrop-filter' => 'Backdrop filter',
            'backdrop-blur' => 'Backdrop blur',
            'overflow-hidden' => 'Overflow hidden',
            'overflow-auto' => 'Overflow auto',
            'overflow-x-hidden' => 'Overflow X hidden',
            'overflow-y-hidden' => 'Overflow Y hidden',
            'isolation' => 'CSS isolation',
            'translate' => 'Transform / translate',
        ];

        $found = false;

        foreach ($files as $file) {
            $content = File::get(
                $file->getPathname()
            );

            $lines = preg_split(
                '/\R/',
                $content
            );

            foreach ($lines as $number => $line) {
                foreach (
                    $patterns as $pattern => $label
                ) {
                    if (
                        stripos(
                            $line,
                            $pattern
                        ) === false
                    ) {
                        continue;
                    }

                    $found = true;
                    $this->stats['risk_matches']++;

                    $relative =
                        $this->relative(
                            $file->getPathname(),
                            $this->viewsPath
                        );

                    $this->riskMatches[] = [
                        'file' => $relative,
                        'line' => $number + 1,
                        'type' => $label,
                    ];

                    $this->line(
                        sprintf(
                            '<fg=yellow>%s:%d</> [%s]',
                            $relative,
                            $number + 1,
                            $label
                        )
                    );

                    $trimmed = trim($line);

                    if ($trimmed !== '') {
                        $this->line(
                            '   ' .
                            mb_substr(
                                $trimmed,
                                0,
                                180
                            )
                        );
                    }

                    break;
                }
            }
        }

        if (!$found) {
            $this->successLine(
                'No obvious stacking or positioning risks found.'
            );
        }
    }

    private function analyzeDynamicViews(array $files): void
    {
        $this->section(
            'DYNAMIC VIEW REFERENCES'
        );

        $patterns = [
            'view($' => 'Dynamic view()',
            'view(' => 'view() usage',
            '@include($' => 'Dynamic @include',
            '@include(' => '@include usage',
            'include($' => 'Dynamic include',
            'public.blocks.' => 'Dynamic block renderer',
            'page-builder.' => 'Page Builder reference',
        ];

        $found = false;

        foreach ($files as $file) {
            $content = File::get(
                $file->getPathname()
            );

            foreach (
                $patterns as $pattern => $label
            ) {
                if (
                    stripos(
                        $content,
                        $pattern
                    ) === false
                ) {
                    continue;
                }

                $found = true;
                $this->stats['dynamic_references']++;

                $relative =
                    $this->relative(
                        $file->getPathname(),
                        $this->viewsPath
                    );

                $this->dynamicReferences[] = [
                    'file' => $relative,
                    'type' => $label,
                ];

                $this->line(
                    '<fg=yellow>' .
                    $relative .
                    '</>'
                );

                $this->line(
                    '  └─ ' .
                    $label .
                    ': ' .
                    $pattern
                );
            }
        }

        if (!$found) {
            $this->dimLine(
                'No dynamic view references detected.'
            );
        }
    }

    private function analyzeHeaderNavigationFooter(): void
    {
        $this->section(
            'HEADER / NAVIGATION / FOOTER ARCHITECTURE'
        );

        $files = [
            'Legacy Navbar' =>
                'public/partials/navbar.blade.php',

            'Page Builder Header' =>
                'public/page-builder/Header/header.blade.php',

            'Legacy Footer' =>
                'public/partials/footer.blade.php',

            'Page Builder Footer' =>
                'public/page-builder/Footer/footer.blade.php',

            'Page Builder Navigation' =>
                'public/page-builder/Navigation/navigation.blade.php',

            'Legacy Navigation' =>
                'layouts/navigation.blade.php',
        ];

        foreach ($files as $label => $relative) {
            if (
                File::exists(
                    $this->absoluteViewPath($relative)
                )
            ) {
                $this->line(
                    '  ' .
                    $label .
                    ' -> ' .
                    $relative
                );
            }
        }

        $this->newLine();

        $this->warningLine(
            'Multiple Header/Navbar/Footer files are not automatically duplicates.'
        );

        $this->line(
            'Their actual references and rendering path must be checked.'
        );
    }

    private function architectureCheck(): void
    {
        $this->section(
            'PUBLIC SITE ARCHITECTURE CHECK'
        );

        $checks = [
            'Public Layout' =>
                'layouts/public.blade.php',

            'Page Entry' =>
                'public/page.blade.php',

            'Home Entry' =>
                'public/home.blade.php',

            'Page Builder Header' =>
                'public/page-builder/Header/header.blade.php',

            'Page Builder Navigation' =>
                'public/page-builder/Navigation/navigation.blade.php',

            'Page Builder Footer' =>
                'public/page-builder/Footer/footer.blade.php',

            'Legacy Navbar' =>
                'public/partials/navbar.blade.php',

            'Legacy Footer' =>
                'public/partials/footer.blade.php',
        ];

        foreach ($checks as $label => $relative) {
            if (
                File::exists(
                    $this->absoluteViewPath($relative)
                )
            ) {
                $this->successLine(
                    $label . ' : PRESENT'
                );
            } else {
                $this->warningLine(
                    $label . ' : NOT FOUND'
                );
            }
        }

        $this->newLine();

        $layout = $this->absoluteViewPath(
            'layouts/public.blade.php'
        );

        $page = $this->absoluteViewPath(
            'public/page.blade.php'
        );

        if (File::exists($layout)) {
            $content = File::get($layout);

            if (
                !str_contains(
                    $content,
                    '@include('
                ) &&
                !str_contains(
                    $content,
                    '@includeIf('
                )
            ) {
                $this->warningLine(
                    'Public layout does not contain a static include.'
                );
            }
        }

        if (File::exists($page)) {
            $content = File::get($page);

            if (
                !str_contains(
                    $content,
                    '@extends('
                )
            ) {
                $this->warningLine(
                    'public/page.blade.php does not appear to extend a layout.'
                );
            }
        }
    }

    private function analyzeCommonProblems(array $files): void
    {
        $this->section(
            'COMMON PUBLIC-SITE PROBLEM SCAN'
        );

        $checks = [
            'debug_dump' => [
                'dd(',
                'dump(',
                'ray(',
                'var_dump(',
            ],

            'temporary_comments' => [
                'TODO',
                'FIXME',
                'HACK',
            ],

            'inline_script' => [
                '<script',
            ],

            'inline_style' => [
                '<style',
            ],
        ];

        $found = false;

        foreach ($files as $file) {
            $content = File::get(
                $file->getPathname()
            );

            $relative =
                $this->relative(
                    $file->getPathname(),
                    $this->viewsPath
                );

            foreach (
                $checks as $category => $patterns
            ) {
                foreach ($patterns as $pattern) {
                    if (
                        stripos(
                            $content,
                            $pattern
                        ) === false
                    ) {
                        continue;
                    }

                    $found = true;

                    if ($category === 'debug_dump') {
                        $this->warningLine(
                            $relative .
                            ' contains debug code: ' .
                            $pattern
                        );

                        $this->addWarning(
                            $relative .
                            ' contains debug code.'
                        );
                    }

                    if (
                        $category ===
                        'temporary_comments'
                    ) {
                        $this->infoLine(
                            $relative .
                            ' contains development marker: ' .
                            $pattern
                        );
                    }

                    if (
                        $category ===
                        'inline_script'
                    ) {
                        $this->infoLine(
                            $relative .
                            ' contains inline JavaScript.'
                        );
                    }

                    if (
                        $category ===
                        'inline_style'
                    ) {
                        $this->infoLine(
                            $relative .
                            ' contains inline CSS.'
                        );
                    }

                    break;
                }
            }
        }

        if (!$found) {
            $this->successLine(
                'No common development/debug patterns detected.'
            );
        }
    }

    private function finalSummary(): void
    {
        $this->section(
            'FINAL HEALTH REPORT'
        );

        $this->line(
            'Files analyzed       : ' .
            $this->stats['files']
        );

        $this->line(
            'Public files         : ' .
            $this->stats['public_files']
        );

        $this->line(
            'Block files          : ' .
            $this->stats['block_files']
        );

        $this->line(
            'Page Builder files   : ' .
            $this->stats['page_builder_files']
        );

        $this->line(
            'Blade references     : ' .
            $this->stats['references']
        );

        $this->line(
            'Dynamic references   : ' .
            $this->stats['dynamic_references']
        );

        $this->line(
            'Broken references    : ' .
            $this->stats['broken_references']
        );

        $this->line(
            'Risk matches         : ' .
            $this->stats['risk_matches']
        );

        $this->line(
            'Duplicate groups     : ' .
            $this->stats['duplicate_groups']
        );

        $this->newLine();

        if (
            $this->stats['broken_references'] > 0
        ) {
            $this->errorLine(
                'CRITICAL: Broken Blade references detected.'
            );
        }

        if (
            $this->stats['errors'] > 0
        ) {
            $this->errorLine(
                'CRITICAL: ' .
                $this->stats['errors'] .
                ' errors detected.'
            );
        }

        if (
            $this->stats['warnings'] > 0
        ) {
            $this->warningLine(
                'WARNINGS: ' .
                $this->stats['warnings']
            );
        }

        if (
            $this->stats['broken_references'] === 0 &&
            $this->stats['errors'] === 0
        ) {
            $this->successLine(
                'No critical Blade reference errors detected.'
            );
        }

        if (
            $this->stats['risk_matches'] > 0
        ) {
            $this->warningLine(
                'CSS/stacking patterns require manual review.'
            );
        }

        $this->newLine();

        $this->line(
            '<fg=cyan;options=bold>RECOMMENDATIONS</>'
        );

        $this->line(
            '1. Fix broken Blade references first.'
        );

        $this->line(
            '2. Review dynamic view/block rendering.'
        );

        $this->line(
            '3. Verify which Header/Navbar/Footer is actually rendered.'
        );

        $this->line(
            '4. Review z-index, overflow, fixed and sticky combinations.'
        );

        $this->line(
            '5. Do not delete possible duplicates until references are verified.'
        );

        $this->line(
            '6. Keep Page Builder rendering independent from legacy components.'
        );

        $this->newLine();

        $this->line(
            '<fg=cyan;options=bold>ANALYSIS COMPLETE</>'
        );

        $this->line(
            str_repeat('=', 75)
        );

        $this->successLine(
            'No files were modified, deleted or created.'
        );

        $this->newLine();
    }

    private function addWarning(string $message): void
    {
        $this->stats['warnings']++;
        $this->warnings[] = $message;
    }

    private function addError(string $message): void
    {
        $this->stats['errors']++;
        $this->errors[] = $message;
    }

    private function addInfo(string $message): void
    {
        $this->stats['info_messages']++;
        $this->infos[] = $message;
    }

    private function hasCriticalProblems(): bool
    {
        return
            $this->stats['errors'] > 0 ||
            $this->stats['broken_references'] > 0;
    }

    private function outputJson(): void
    {
        $data = [
            'summary' => $this->stats,
            'warnings' => $this->warnings,
            'errors' => $this->errors,
            'info' => $this->infos,
            'broken_references' =>
                $this->brokenReferences,
            'dynamic_references' =>
                $this->dynamicReferences,
            'risk_matches' =>
                $this->riskMatches,
        ];

        $this->line(
            json_encode(
                $data,
                JSON_PRETTY_PRINT |
                JSON_UNESCAPED_SLASHES |
                JSON_UNESCAPED_UNICODE
            )
        );
    }

    private function bladeFiles(string $directory): array
    {
        if (!File::isDirectory($directory)) {
            return [];
        }

        return array_values(
            array_filter(
                File::allFiles($directory),
                function ($file) {
                    return str_ends_with(
                        strtolower(
                            $file->getFilename()
                        ),
                        '.blade.php'
                    );
                }
            )
        );
    }

    private function absoluteViewPath(
        string $relative
    ): string {
        return
            $this->viewsPath .
            DIRECTORY_SEPARATOR .
            str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $relative
            );
    }

    private function relative(
        string $path,
        string $base
    ): string {
        $relative = str_replace(
            $base . DIRECTORY_SEPARATOR,
            '',
            $path
        );

        return str_replace(
            DIRECTORY_SEPARATOR,
            '/',
            $relative
        );
    }

    private function header(): void
    {
        $this->newLine();

        $this->line(
            '<fg=cyan;options=bold>' .
            'DEV-PLATFORM PUBLIC SITE ANALYZER' .
            '</>'
        );

        $this->line(
            '<fg=gray>' .
            'Laravel Blade / Page Builder / Blocks / Layout / Header / Navigation / Footer' .
            '</>'
        );

        $this->line(
            str_repeat('=', 75)
        );
    }

    private function section(string $title): void
    {
        $this->newLine();

        $this->line(
            '<fg=cyan;options=bold>' .
            $title .
            '</>'
        );

        $this->line(
            str_repeat('-', 75)
        );
    }

    private function successLine(
        string $message
    ): void {
        $this->line(
            '<fg=green>✓ ' .
            $message .
            '</>'
        );
    }

    private function warningLine(
        string $message
    ): void {
        $this->line(
            '<fg=yellow>⚠ ' .
            $message .
            '</>'
        );
    }

    private function errorLine(
        string $message
    ): void {
        $this->line(
            '<fg=red>✗ ' .
            $message .
            '</>'
        );
    }

    private function infoLine(
        string $message
    ): void {
        $this->line(
            '<fg=blue>ℹ ' .
            $message .
            '</>'
        );
    }

    private function dimLine(
        string $message
    ): void {
        $this->line(
            '<fg=gray>' .
            $message .
            '</>'
        );
    }
}
