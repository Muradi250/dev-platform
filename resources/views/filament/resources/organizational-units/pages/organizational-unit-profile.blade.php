@php
    $isRtl = in_array(app()->getLocale(), ['fa', 'ps'], true);
    $labels = $isRtl
        ? [
            'document' => 'پروفایل واحد سازمانی',
            'subtitle' => 'سند ساختار و اطلاعات واحد سازمانی',
            'reference' => 'شناسه واحد',
            'issued' => 'تاریخ صدور',
            'status' => 'وضعیت',
            'identity' => 'مشخصات واحد',
            'name' => 'نام واحد',
            'code' => 'کد واحد',
            'type' => 'نوع واحد',
            'organization' => 'سازمان',
            'parent' => 'واحد بالادست',
            'hierarchy' => 'جایگاه در ساختار سازمانی',
            'root' => 'واحد اصلی سازمان',
            'head' => 'مسئول واحد',
            'head_email' => 'ایمیل مسئول',
            'head_phone' => 'تلفن مسئول',
            'location' => 'محل استقرار',
            'effective' => 'دوره اعتبار',
            'effective_from' => 'تاریخ شروع',
            'effective_until' => 'تاریخ پایان',
            'description' => 'معرفی واحد',
            'summary' => 'خلاصه واحد',
            'children' => 'واحدهای زیرمجموعه',
            'employees' => 'کارمندان',
            'active_employees' => 'کارمندان فعال',
            'child_count' => 'واحد زیرمجموعه',
            'staff' => 'کارمندان واحد',
            'employee_number' => 'شماره کارمندی',
            'position' => 'سمت',
            'not_provided' => 'ثبت نشده',
            'authorization' => 'تأیید سازمان',
            'representative' => 'نماینده مجاز',
            'signature' => 'امضا',
            'seal' => 'مهر',
            'generated' => 'این سند به‌صورت سیستمی تولید شده و براساس اطلاعات ثبت‌شده در سامانه است.',
        ]
        : [
            'document' => 'Organizational Unit Profile',
            'subtitle' => 'Organizational structure and unit record',
            'reference' => 'Unit reference',
            'issued' => 'Date issued',
            'status' => 'Status',
            'identity' => 'Unit identity',
            'name' => 'Unit name',
            'code' => 'Unit code',
            'type' => 'Unit type',
            'organization' => 'Organization',
            'parent' => 'Parent unit',
            'hierarchy' => 'Organizational hierarchy',
            'root' => 'Organization root unit',
            'head' => 'Unit head',
            'head_email' => 'Head email',
            'head_phone' => 'Head phone',
            'location' => 'Office / location',
            'effective' => 'Effective period',
            'effective_from' => 'Effective from',
            'effective_until' => 'Effective until',
            'description' => 'Unit overview',
            'summary' => 'Unit summary',
            'children' => 'Sub-units',
            'employees' => 'Employees',
            'active_employees' => 'Active employees',
            'child_count' => 'Child units',
            'staff' => 'Unit personnel',
            'employee_number' => 'Employee number',
            'position' => 'Job title',
            'not_provided' => 'Not provided',
            'authorization' => 'Organization authorization',
            'representative' => 'Authorized representative',
            'signature' => 'Signature',
            'seal' => 'Official seal',
            'generated' => 'System-generated profile based on information maintained in this platform.',
        ];

    $value = fn ($item): string => filled($item) ? (string) $item : $labels['not_provided'];
    $statusLabel = match ($unit->status) {
        'active' => $isRtl ? 'فعال' : 'Active',
        'inactive' => $isRtl ? 'غیرفعال' : 'Inactive',
        'suspended' => $isRtl ? 'تعلیق‌شده' : 'Suspended',
        default => ucfirst((string) $unit->status),
    };
    $unitType = str($unit->type)->replace('_', ' ')->title();
@endphp

<div class="unit-profile-page" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    @if (! ($hideProfileToolbar ?? false))
        <div class="unit-profile-toolbar">
            <a href="{{ $editUrl }}" class="unit-profile-button">{{ $isRtl ? 'ویرایش واحد' : 'Edit unit' }}</a>
            <button type="button" class="unit-profile-button" wire:click="downloadPdf" wire:loading.attr="disabled" wire:target="downloadPdf">
                {{ $isRtl ? 'دانلود PDF' : 'Download PDF' }}
            </button>
            <button type="button" class="unit-profile-button unit-profile-print" onclick="window.print()">
                {{ $isRtl ? 'چاپ / ذخیره PDF' : 'Print / Save as PDF' }}
            </button>
        </div>
    @endif

    <article class="unit-profile-document">
        <div class="dp-document-brand">
            <div class="dp-brand-mark" aria-hidden="true"><span>DP</span><i></i></div>
            <div class="dp-brand-copy">
                <strong>Dev-Platform</strong>
                <span>{{ $isRtl ? 'سامانه مدیریت سازمانی' : 'Enterprise Management System' }}</span>
            </div>
            <span class="dp-brand-caption">{{ $isRtl ? 'ساختار سازمانی' : 'ORGANIZATION STRUCTURE' }}</span>
        </div>

        <header class="unit-profile-header">
            <div class="unit-profile-identity">
                @if ($organizationLogoUrl)
                    <img src="{{ $organizationLogoUrl }}" alt="{{ $unit->organization?->name }}" class="unit-profile-org-logo">
                @else
                    <div class="unit-profile-org-logo unit-profile-org-fallback" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($unit->organization?->name ?? 'O', 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="unit-profile-kicker">{{ $labels['subtitle'] }}</p>
                    <h1>{{ $labels['document'] }}</h1>
                    <p class="unit-profile-name">{{ $unit->name }}</p>
                    <p class="unit-profile-org-name">{{ $unit->organization?->name }}</p>
                </div>
            </div>

            <div class="unit-profile-reference">
                <div><span>{{ $labels['reference'] }}</span><strong>{{ $unit->code }}</strong></div>
                <div><span>{{ $labels['issued'] }}</span><strong>{{ $issuedAt->format('Y-m-d') }}</strong></div>
                <div><span>{{ $labels['status'] }}</span><strong class="unit-profile-status-{{ $unit->status }}">{{ $statusLabel }}</strong></div>
            </div>
        </header>

        <section class="unit-profile-section">
            <h2>{{ $labels['identity'] }}</h2>
            <dl class="unit-profile-grid">
                <div><dt>{{ $labels['name'] }}</dt><dd>{{ $value($unit->name) }}</dd></div>
                <div><dt>{{ $labels['code'] }}</dt><dd>{{ $value($unit->code) }}</dd></div>
                <div><dt>{{ $labels['type'] }}</dt><dd>{{ $unitType }}</dd></div>
                <div><dt>{{ $labels['organization'] }}</dt><dd>{{ $value($unit->organization?->name) }}</dd></div>
            </dl>
        </section>

        <section class="unit-profile-section">
            <h2>{{ $labels['hierarchy'] }}</h2>
            <div class="unit-profile-hierarchy">
                @forelse ($ancestors as $ancestor)
                    <a href="{{ \App\Filament\Resources\OrganizationalUnits\OrganizationalUnitResource::getUrl('view', ['record' => $ancestor]) }}">
                        {{ $ancestor->name }}
                    </a>
                    <span aria-hidden="true">›</span>
                @empty
                    <span>{{ $labels['root'] }}</span>
                    <span aria-hidden="true">›</span>
                @endforelse
                <strong>{{ $unit->name }}</strong>
            </div>
            <dl class="unit-profile-grid unit-profile-hierarchy-details">
                <div><dt>{{ $labels['parent'] }}</dt><dd>{{ $value($unit->parent?->name) }}</dd></div>
                <div><dt>{{ $labels['child_count'] }}</dt><dd>{{ number_format($unit->children_count) }}</dd></div>
            </dl>
        </section>

        <section class="unit-profile-section">
            <h2>{{ $labels['head'] }}</h2>
            <dl class="unit-profile-grid">
                <div><dt>{{ $labels['head'] }}</dt><dd>{{ $value($unit->head_name) }}</dd></div>
                <div><dt>{{ $labels['head_email'] }}</dt><dd>{{ $value($unit->head_email) }}</dd></div>
                <div><dt>{{ $labels['head_phone'] }}</dt><dd>{{ $value($unit->head_phone) }}</dd></div>
                <div><dt>{{ $labels['location'] }}</dt><dd>{{ $value($unit->location) }}</dd></div>
                <div><dt>{{ $labels['effective_from'] }}</dt><dd>{{ $unit->effective_from?->format('Y-m-d') ?? $labels['not_provided'] }}</dd></div>
                <div><dt>{{ $labels['effective_until'] }}</dt><dd>{{ $unit->effective_until?->format('Y-m-d') ?? $labels['not_provided'] }}</dd></div>
            </dl>
        </section>

        @if (filled($unit->description))
            <section class="unit-profile-section">
                <h2>{{ $labels['description'] }}</h2>
                <p class="unit-profile-notes">{{ $unit->description }}</p>
            </section>
        @endif

        <section class="unit-profile-section">
            <h2>{{ $labels['summary'] }}</h2>
            <div class="unit-profile-stats">
                <div><strong>{{ number_format($unit->children_count) }}</strong><span>{{ $labels['children'] }}</span></div>
                <div><strong>{{ number_format($unit->employees_count) }}</strong><span>{{ $labels['employees'] }}</span></div>
                <div><strong>{{ number_format($unit->active_employees_count) }}</strong><span>{{ $labels['active_employees'] }}</span></div>
            </div>
        </section>

        @if ($unit->children->isNotEmpty())
            <section class="unit-profile-section">
                <h2>{{ $labels['children'] }}</h2>
                <div class="unit-profile-child-list">
                    @foreach ($unit->children as $child)
                        <a href="{{ \App\Filament\Resources\OrganizationalUnits\OrganizationalUnitResource::getUrl('view', ['record' => $child]) }}">
                            <span>{{ $child->name }}</span>
                            <small>{{ $child->code }} · {{ str($child->type)->replace('_', ' ')->title() }}</small>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($unit->employees->isNotEmpty())
            <section class="unit-profile-section">
                <h2>{{ $labels['staff'] }}</h2>
                <div class="unit-profile-staff">
                    @foreach ($unit->employees as $employee)
                        <div>
                            <strong>{{ $employee->full_name }}</strong>
                            <span>{{ $employee->employee_number }}</span>
                            <small>{{ $value($employee->job_title) }}</small>
                        </div>
                    @endforeach
                    @if ($unit->employees_count > $unit->employees->count())
                        <p>{{ number_format($unit->employees_count - $unit->employees->count()) }} {{ $isRtl ? 'کارمند دیگر در فهرست کامل وجود دارد.' : 'more employees are listed in the directory.' }}</p>
                    @endif
                </div>
            </section>
        @endif

        <footer class="unit-profile-footer">
            <h2>{{ $labels['authorization'] }}</h2>
            <div class="unit-profile-signatures">
                <div><span>{{ $labels['representative'] }}</span><i></i><small>{{ $labels['signature'] }}</small></div>
                <div><span>{{ $labels['seal'] }}</span><i></i><small>&nbsp;</small></div>
            </div>
            <p>{{ $labels['generated'] }}</p>
            <div class="dp-document-signoff">
                <span class="dp-signoff-line"></span>
                <span>{{ $isRtl ? 'مدیریت سازمانی با' : 'Organized with' }}</span>
                <strong><span class="dp-signoff-mark">DP</span> Dev-Platform</strong>
                <span class="dp-signoff-line"></span>
            </div>
        </footer>
    </article>
</div>

<style>
    .dp-document-brand { display: flex; align-items: center; gap: .75rem; min-height: 58px; margin-bottom: 1.1rem; padding: .65rem .8rem; border: 1px solid #e2e8f0; border-radius: .65rem; background: linear-gradient(105deg, #f8fafc 0%, #eff6ff 100%); }
    .dp-brand-mark { position: relative; display: grid; width: 2.55rem; height: 2.55rem; flex: 0 0 2.55rem; place-items: center; overflow: hidden; border-radius: .7rem; background: linear-gradient(145deg, #17365d, #2563a6); color: #fff; }
    .dp-brand-mark span { position: relative; z-index: 1; font-size: .8rem; font-weight: 850; letter-spacing: -.06em; }
    .dp-brand-mark i { position: absolute; right: -.25rem; bottom: -.5rem; width: 1.4rem; height: 1.4rem; border: 2px solid rgb(255 255 255 / 40%); border-radius: 50%; }
    .dp-brand-copy { display: grid; gap: .1rem; }
    .dp-brand-copy strong { color: #17365d; font-size: .9rem; font-weight: 800; }
    .dp-brand-copy span { color: #64748b; font-size: .65rem; }
    .dp-brand-caption { margin-inline-start: auto; padding: .3rem .55rem; border: 1px solid #dbe5f0; border-radius: 999px; color: #526783; font-size: .58rem; font-weight: 750; letter-spacing: .09em; }
    .dp-document-signoff { display: flex; align-items: center; justify-content: center; gap: .5rem; margin-top: 1rem; color: #64748b; font-size: .65rem; }
    .dp-document-signoff strong { color: #17365d; font-size: .72rem; font-weight: 800; white-space: nowrap; }
    .dp-signoff-mark { display: inline-grid; width: 1.2rem; height: 1.2rem; margin-inline-end: .15rem; place-items: center; border-radius: .3rem; background: #17365d; color: #fff; font-size: .52rem; }
    .dp-signoff-line { width: 1.6rem; border-top: 1px solid #cbd5e1; }
    .unit-profile-page { max-width: 980px; margin: 1.5rem auto; color: #172033; }
    .unit-profile-toolbar { display: flex; justify-content: flex-end; gap: .75rem; margin-bottom: 1rem; }
    .unit-profile-button { border: 1px solid #cbd5e1; border-radius: .5rem; padding: .6rem 1rem; background: #fff; color: #172033; font-weight: 600; text-decoration: none; cursor: pointer; }
    .unit-profile-print { border-color: #17365d; background: #17365d; color: #fff; }
    .unit-profile-document { min-height: 980px; padding: 2.25rem; border: 1px solid #cbd5e1; background: #fff; box-shadow: 0 12px 35px rgb(15 23 42 / 10%); }
    .unit-profile-header { display: flex; justify-content: space-between; gap: 2rem; padding-bottom: 1.5rem; border-bottom: 3px solid #17365d; }
    .unit-profile-identity { display: flex; align-items: center; gap: 1rem; }
    .unit-profile-org-logo { width: 4.25rem; height: 4.25rem; flex: 0 0 4.25rem; object-fit: contain; border: 1px solid #dbe3ec; border-radius: .65rem; }
    .unit-profile-org-fallback { display: grid; place-items: center; background: #f1f5f9; color: #17365d; font-size: 1.7rem; font-weight: 750; }
    .unit-profile-kicker { margin: 0 0 .35rem; color: #64748b; font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .unit-profile-header h1 { margin: 0; color: #17365d; font-size: 1.55rem; font-weight: 800; }
    .unit-profile-name { margin: .35rem 0 0; color: #172033; font-size: 1.1rem; font-weight: 700; }
    .unit-profile-org-name { margin: .15rem 0 0; color: #64748b; font-size: .85rem; }
    .unit-profile-reference { min-width: 190px; display: grid; align-content: center; gap: .55rem; }
    .unit-profile-reference div { display: flex; justify-content: space-between; gap: .75rem; font-size: .72rem; }
    .unit-profile-reference span, .unit-profile-section dt { color: #64748b; }
    .unit-profile-reference strong { text-align: end; }
    .unit-profile-status-active { color: #15803d; }
    .unit-profile-status-inactive { color: #64748b; }
    .unit-profile-status-suspended { color: #b45309; }
    .unit-profile-section { margin-top: 1.45rem; break-inside: avoid; }
    .unit-profile-section h2, .unit-profile-footer h2 { margin: 0 0 .75rem; padding-bottom: .4rem; border-bottom: 1px solid #dbe3ec; color: #17365d; font-size: .95rem; font-weight: 750; }
    .unit-profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .8rem 1.5rem; margin: 0; }
    .unit-profile-grid > div { min-width: 0; }
    .unit-profile-grid dt { margin-bottom: .2rem; font-size: .7rem; font-weight: 650; }
    .unit-profile-grid dd { margin: 0; overflow-wrap: anywhere; font-size: .85rem; font-weight: 550; }
    .unit-profile-hierarchy { display: flex; flex-wrap: wrap; align-items: center; gap: .45rem; margin-bottom: .85rem; padding: .7rem .8rem; border: 1px solid #dbe5f0; border-radius: .55rem; background: #f8fafc; color: #64748b; font-size: .78rem; }
    .unit-profile-hierarchy a { color: #2563a6; text-decoration: none; }
    .unit-profile-hierarchy strong { color: #17365d; }
    .unit-profile-hierarchy-details { padding-top: .2rem; }
    .unit-profile-notes { margin: 0; color: #334155; font-size: .85rem; line-height: 1.7; white-space: pre-line; }
    .unit-profile-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
    .unit-profile-stats div { display: grid; gap: .2rem; padding: .8rem; border: 1px solid #dbe3ec; border-radius: .5rem; text-align: center; }
    .unit-profile-stats strong { color: #17365d; font-size: 1.15rem; }
    .unit-profile-stats span { color: #64748b; font-size: .72rem; }
    .unit-profile-child-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .6rem; }
    .unit-profile-child-list a { display: grid; gap: .2rem; padding: .65rem .75rem; border: 1px solid #dbe3ec; border-radius: .5rem; color: #17365d; text-decoration: none; }
    .unit-profile-child-list span { font-size: .82rem; font-weight: 700; }
    .unit-profile-child-list small { color: #64748b; font-size: .68rem; }
    .unit-profile-staff { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .55rem; }
    .unit-profile-staff > div { display: grid; grid-template-columns: 1fr auto; gap: .2rem .6rem; padding: .6rem .7rem; border: 1px solid #e2e8f0; border-radius: .45rem; }
    .unit-profile-staff strong { color: #172033; font-size: .78rem; }
    .unit-profile-staff span, .unit-profile-staff small { color: #64748b; font-size: .68rem; }
    .unit-profile-staff small { grid-column: 1 / -1; }
    .unit-profile-staff > p { grid-column: 1 / -1; color: #64748b; font-size: .72rem; }
    .unit-profile-footer { margin-top: 1.7rem; break-inside: avoid; }
    .unit-profile-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 1rem .5rem .5rem; }
    .unit-profile-signatures div { display: grid; min-height: 90px; align-content: space-between; color: #475569; font-size: .75rem; }
    .unit-profile-signatures i { display: block; border-bottom: 1px solid #94a3b8; }
    .unit-profile-signatures small { padding-top: .25rem; color: #64748b; }
    .unit-profile-footer > p { margin: .75rem 0 0; color: #64748b; font-size: .68rem; text-align: center; }
    [dir="rtl"] .unit-profile-reference div { flex-direction: row-reverse; }
    [dir="rtl"] .unit-profile-reference strong { text-align: start; }
    @media (max-width: 700px) {
        .dp-brand-caption { max-width: 7rem; text-align: center; }
        .unit-profile-document { min-height: 0; padding: 1.25rem; }
        .unit-profile-header { flex-direction: column; gap: 1rem; }
        .unit-profile-grid, .unit-profile-child-list, .unit-profile-staff { grid-template-columns: 1fr; }
    }
    @page { size: A4; margin: 16mm; }
    @media print {
        .fi-topbar-ctn, .fi-sidebar, .fi-breadcrumbs, .fi-page-header, .fi-page-header-actions, .unit-profile-toolbar { display: none !important; }
        body, .fi-body, .fi-main, .fi-page, .fi-page-content, .fi-main-ctn { background: #fff !important; color: #172033 !important; }
        .fi-main { margin: 0 !important; padding: 0 !important; }
        .unit-profile-page { max-width: none; margin: 0; }
        .unit-profile-document { min-height: 0; padding: 0; border: 0; box-shadow: none; }
        .dp-document-brand { border: 0; border-bottom: 1px solid #cbd5e1; border-radius: 0; background: #fff; }
        .unit-profile-section, .unit-profile-footer, .unit-profile-header { break-inside: avoid; }
        a { color: inherit; text-decoration: none; }
        * { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    }
</style>
