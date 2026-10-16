@php
    $isRtl = in_array(app()->getLocale(), ['fa', 'ps'], true);
    $labels = $isRtl
        ? [
            'profile' => 'پروفایل کارمند',
            'subtitle' => 'سند اطلاعات ثبت‌شده در سامانه',
            'issued' => 'تاریخ صدور',
            'status' => 'وضعیت',
            'identity' => 'مشخصات فردی و سازمانی',
            'name' => 'نام کامل',
            'number' => 'شماره کارمندی',
            'organization' => 'سازمان',
            'unit' => 'واحد سازمانی',
            'position' => 'سمت',
            'employment_type' => 'نوع استخدام',
            'employment_status' => 'وضعیت استخدام',
            'joined' => 'تاریخ شروع',
            'ended' => 'تاریخ پایان',
            'contact' => 'اطلاعات تماس',
            'work_email' => 'ایمیل کاری',
            'phone' => 'تلفن',
            'account' => 'حساب کاربری سامانه',
            'emergency' => 'تماس اضطراری',
            'contact_name' => 'نام شخص',
            'contact_phone' => 'شماره تماس',
            'relationship' => 'نسبت',
            'description' => 'توضیحات',
            'authorization' => 'تأیید سازمان',
            'representative' => 'نماینده مجاز',
            'signature' => 'امضا',
            'seal' => 'مهر',
            'generated' => 'این سند به‌صورت سیستمی تولید شده است. اعتبار اطلاعات منوط به سوابق ثبت‌شده در سامانه است.',
            'not_found' => 'ثبت نشده',
        ]
        : [
            'profile' => 'Employee Profile',
            'subtitle' => 'Personnel record maintained in the platform',
            'issued' => 'Date issued',
            'status' => 'Status',
            'identity' => 'Personal and organization details',
            'name' => 'Full name',
            'number' => 'Employee number',
            'organization' => 'Organization',
            'unit' => 'Organizational unit',
            'position' => 'Job title',
            'employment_type' => 'Employment type',
            'employment_status' => 'Employment status',
            'joined' => 'Join date',
            'ended' => 'End date',
            'contact' => 'Contact information',
            'work_email' => 'Work email',
            'phone' => 'Phone',
            'account' => 'Platform user account',
            'emergency' => 'Emergency contact',
            'contact_name' => 'Contact name',
            'contact_phone' => 'Contact phone',
            'relationship' => 'Relationship',
            'description' => 'Notes',
            'authorization' => 'Organization authorization',
            'representative' => 'Authorized representative',
            'signature' => 'Signature',
            'seal' => 'Official seal',
            'generated' => 'System-generated profile. Information is based on records maintained in this platform.',
            'not_found' => 'Not provided',
        ];

    $value = fn ($item): string => filled($item) ? (string) $item : $labels['not_found'];
    $employeeStatus = match ($employee->status) {
        'active' => $isRtl ? 'فعال' : 'Active',
        'inactive' => $isRtl ? 'غیرفعال' : 'Inactive',
        'suspended' => $isRtl ? 'تعلیق‌شده' : 'Suspended',
        'terminated' => $isRtl ? 'خاتمه‌یافته' : 'Terminated',
        default => ucfirst((string) $employee->status),
    };
    $employmentType = str($employee->employment_type)->replace('_', ' ')->title();
@endphp

<div class="employee-profile-page" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    @if (! ($hideProfileToolbar ?? false))
        <div class="employee-profile-toolbar">
            <a href="{{ $editUrl }}" class="employee-profile-button">
                {{ $isRtl ? 'ویرایش اطلاعات' : 'Edit employee' }}
            </a>
            <button type="button" class="employee-profile-button" wire:click="downloadPdf" wire:loading.attr="disabled" wire:target="downloadPdf">
                {{ $isRtl ? 'دانلود PDF' : 'Download PDF' }}
            </button>
            <button type="button" class="employee-profile-button employee-profile-print" onclick="window.print()">
                {{ $isRtl ? 'چاپ / ذخیره PDF' : 'Print / Save as PDF' }}
            </button>
        </div>
    @endif

    <article class="employee-profile-document">
        <div class="dp-document-brand">
            <div class="dp-brand-mark" aria-hidden="true"><span>DP</span><i></i></div>
            <div class="dp-brand-copy">
                <strong>Dev-Platform</strong>
                <span>{{ $isRtl ? 'سامانه مدیریت سازمانی' : 'Enterprise Management System' }}</span>
            </div>
            <span class="dp-brand-caption">{{ $isRtl ? 'سند منابع انسانی' : 'PEOPLE & ORGANIZATION' }}</span>
        </div>

        <header class="employee-profile-header">
            <div class="employee-profile-person">
                @if ($employee->photo_url)
                    <img src="{{ $employee->photo_url }}" alt="{{ $employee->full_name }}" class="employee-profile-photo">
                @else
                    <div class="employee-profile-photo employee-profile-initials" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($employee->first_name, 0, 1) . \Illuminate\Support\Str::substr($employee->last_name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <p class="employee-profile-kicker">{{ $labels['subtitle'] }}</p>
                    <h1>{{ $labels['profile'] }}</h1>
                    <p class="employee-profile-name">{{ $employee->full_name }}</p>
                    <p class="employee-profile-job">{{ $value($employee->job_title) }}</p>
                </div>
            </div>

            <div class="employee-profile-reference">
                <div class="employee-profile-organization">
                    @if ($organizationLogoUrl ?? false)
                        <img src="{{ $organizationLogoUrl }}" alt="{{ $employee->organization?->name }}" class="employee-profile-organization-logo">
                    @else
                        <span class="employee-profile-organization-mark" aria-hidden="true">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($employee->organization?->name ?? 'O', 0, 1)) }}
                        </span>
                    @endif
                    <strong>{{ $value($employee->organization?->name) }}</strong>
                </div>
                <div><span>{{ $labels['number'] }}</span><strong>{{ $value($employee->employee_number) }}</strong></div>
                <div><span>{{ $labels['issued'] }}</span><strong>{{ $issuedAt->format('Y-m-d') }}</strong></div>
                <div><span>{{ $labels['status'] }}</span><strong class="employee-profile-status-{{ $employee->status }}">{{ $employeeStatus }}</strong></div>
            </div>
        </header>

        <section class="employee-profile-section">
            <h2>{{ $labels['identity'] }}</h2>
            <dl class="employee-profile-grid">
                <div><dt>{{ $labels['name'] }}</dt><dd>{{ $employee->full_name }}</dd></div>
                <div><dt>{{ $labels['number'] }}</dt><dd>{{ $value($employee->employee_number) }}</dd></div>
                <div><dt>{{ $labels['organization'] }}</dt><dd>{{ $value($employee->organization?->name) }}</dd></div>
                <div><dt>{{ $labels['unit'] }}</dt><dd>{{ $value($employee->organizationalUnit?->name) }}</dd></div>
                <div><dt>{{ $labels['position'] }}</dt><dd>{{ $value($employee->job_title) }}</dd></div>
                <div><dt>{{ $labels['employment_type'] }}</dt><dd>{{ $employmentType }}</dd></div>
                <div><dt>{{ $labels['employment_status'] }}</dt><dd>{{ $employeeStatus }}</dd></div>
                <div><dt>{{ $labels['joined'] }}</dt><dd>{{ $employee->joined_at?->format('Y-m-d') ?? $labels['not_found'] }}</dd></div>
                <div><dt>{{ $labels['ended'] }}</dt><dd>{{ $employee->ended_at?->format('Y-m-d') ?? $labels['not_found'] }}</dd></div>
            </dl>
        </section>

        <section class="employee-profile-section">
            <h2>{{ $labels['contact'] }}</h2>
            <dl class="employee-profile-grid">
                <div><dt>{{ $labels['work_email'] }}</dt><dd>{{ $value($employee->work_email ?: $employee->user?->email) }}</dd></div>
                <div><dt>{{ $labels['phone'] }}</dt><dd>{{ $value($employee->phone) }}</dd></div>
                <div class="employee-profile-span-2"><dt>{{ $labels['account'] }}</dt><dd>{{ $value($employee->user?->name) }}</dd></div>
            </dl>
        </section>

        @if ($employee->emergency_contact_name || $employee->emergency_contact_phone || $employee->emergency_contact_relationship)
            <section class="employee-profile-section">
                <h2>{{ $labels['emergency'] }}</h2>
                <dl class="employee-profile-grid">
                    <div><dt>{{ $labels['contact_name'] }}</dt><dd>{{ $value($employee->emergency_contact_name) }}</dd></div>
                    <div><dt>{{ $labels['contact_phone'] }}</dt><dd>{{ $value($employee->emergency_contact_phone) }}</dd></div>
                    <div><dt>{{ $labels['relationship'] }}</dt><dd>{{ $value($employee->emergency_contact_relationship) }}</dd></div>
                </dl>
            </section>
        @endif

        @if (filled($employee->description))
            <section class="employee-profile-section">
                <h2>{{ $labels['description'] }}</h2>
                <p class="employee-profile-description">{{ $employee->description }}</p>
            </section>
        @endif

        <footer class="employee-profile-footer">
            <h2>{{ $labels['authorization'] }}</h2>
            <div class="employee-profile-signatures">
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
    .dp-brand-mark { position: relative; display: grid; width: 2.55rem; height: 2.55rem; flex: 0 0 2.55rem; place-items: center; overflow: hidden; border-radius: .7rem; background: linear-gradient(145deg, #17365d, #2563a6); box-shadow: 0 4px 12px rgb(23 54 93 / 20%); color: white; }
    .dp-brand-mark span { position: relative; z-index: 1; font-size: .8rem; font-weight: 850; letter-spacing: -.06em; }
    .dp-brand-mark i { position: absolute; right: -.25rem; bottom: -.5rem; width: 1.4rem; height: 1.4rem; border: 2px solid rgb(255 255 255 / 40%); border-radius: 50%; }
    .dp-brand-copy { display: grid; gap: .1rem; }
    .dp-brand-copy strong { color: #17365d; font-size: .9rem; font-weight: 800; letter-spacing: -.02em; }
    .dp-brand-copy span { color: #64748b; font-size: .65rem; }
    .dp-brand-caption { margin-inline-start: auto; padding: .3rem .55rem; border: 1px solid #dbe5f0; border-radius: 999px; color: #526783; font-size: .58rem; font-weight: 750; letter-spacing: .09em; }
    .dp-document-signoff { display: flex; align-items: center; justify-content: center; gap: .5rem; margin-top: 1rem; color: #64748b; font-size: .65rem; }
    .dp-document-signoff strong { color: #17365d; font-size: .72rem; font-weight: 800; white-space: nowrap; }
    .dp-signoff-mark { display: inline-grid; width: 1.2rem; height: 1.2rem; margin-inline-end: .15rem; place-items: center; border-radius: .3rem; background: #17365d; color: white; font-size: .52rem; }
    .dp-signoff-line { width: 1.6rem; border-top: 1px solid #cbd5e1; }
    .employee-profile-page { max-width: 980px; margin: 1.5rem auto; color: #172033; }
    .employee-profile-toolbar { display: flex; justify-content: flex-end; gap: .75rem; margin-bottom: 1rem; }
    .employee-profile-button { border: 1px solid #cbd5e1; border-radius: .5rem; padding: .6rem 1rem; background: #fff; color: #172033; font-weight: 600; text-decoration: none; cursor: pointer; }
    .employee-profile-print { border-color: #17365d; background: #17365d; color: #fff; }
    .employee-profile-document { min-height: 980px; padding: 2.25rem; border: 1px solid #cbd5e1; background: #fff; box-shadow: 0 12px 35px rgb(15 23 42 / 10%); }
    .employee-profile-header { display: flex; justify-content: space-between; gap: 2rem; padding-bottom: 1.5rem; border-bottom: 3px solid #17365d; }
    .employee-profile-person { display: flex; align-items: center; gap: 1.15rem; }
    .employee-profile-photo { width: 6.5rem; height: 6.5rem; flex: 0 0 6.5rem; object-fit: cover; border: 2px solid #dbe3ec; border-radius: 50%; }
    .employee-profile-initials { display: grid; place-items: center; background: #eff6ff; color: #17365d; font-size: 1.8rem; font-weight: 750; }
    .employee-profile-kicker { margin: 0 0 .35rem; color: #64748b; font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .employee-profile-header h1 { margin: 0; color: #17365d; font-size: 1.55rem; font-weight: 800; }
    .employee-profile-name { margin: .35rem 0 0; color: #172033; font-size: 1.1rem; font-weight: 700; }
    .employee-profile-job { margin: .15rem 0 0; color: #64748b; font-size: .85rem; }
    .employee-profile-reference { min-width: 185px; display: grid; align-content: center; gap: .55rem; }
    .employee-profile-reference div { display: flex; justify-content: space-between; gap: .75rem; font-size: .75rem; }
    .employee-profile-reference span, .employee-profile-section dt { color: #64748b; }
    .employee-profile-reference strong { text-align: end; }
    .employee-profile-organization { display: flex; align-items: center; justify-content: flex-end; gap: .5rem; padding-bottom: .5rem; border-bottom: 1px solid #e2e8f0; color: #17365d; font-size: .78rem; }
    .employee-profile-organization-logo, .employee-profile-organization-mark { display: grid; width: 2rem; height: 2rem; flex: 0 0 2rem; place-items: center; object-fit: contain; border: 1px solid #dbe3ec; border-radius: .45rem; background: #f8fafc; color: #17365d; font-size: .8rem; font-weight: 750; }
    .employee-profile-status-active { color: #15803d; }
    .employee-profile-status-inactive, .employee-profile-status-suspended, .employee-profile-status-terminated { color: #b91c1c; }
    .employee-profile-section { margin-top: 1.5rem; break-inside: avoid; }
    .employee-profile-section h2, .employee-profile-footer h2 { margin: 0 0 .8rem; padding-bottom: .4rem; border-bottom: 1px solid #dbe3ec; color: #17365d; font-size: .95rem; font-weight: 750; }
    .employee-profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .85rem 1.5rem; margin: 0; }
    .employee-profile-grid > div { min-width: 0; }
    .employee-profile-grid dt { margin-bottom: .2rem; font-size: .7rem; font-weight: 650; }
    .employee-profile-grid dd { margin: 0; overflow-wrap: anywhere; font-size: .85rem; font-weight: 550; }
    .employee-profile-span-2 { grid-column: span 2; }
    .employee-profile-description { margin: 0; color: #334155; font-size: .85rem; line-height: 1.7; white-space: pre-line; }
    .employee-profile-footer { margin-top: 2rem; break-inside: avoid; }
    .employee-profile-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 1rem .5rem .5rem; }
    .employee-profile-signatures div { display: grid; min-height: 95px; align-content: space-between; color: #475569; font-size: .75rem; }
    .employee-profile-signatures i { display: block; border-bottom: 1px solid #94a3b8; }
    .employee-profile-signatures small { padding-top: .25rem; color: #64748b; }
    .employee-profile-footer > p { margin: .75rem 0 0; color: #64748b; font-size: .68rem; text-align: center; }
    @media (max-width: 700px) {
        .dp-brand-caption { max-width: 7rem; text-align: center; }
        .employee-profile-document { min-height: 0; padding: 1.25rem; }
        .employee-profile-header { flex-direction: column; gap: 1rem; }
        .employee-profile-grid { grid-template-columns: 1fr; }
        .employee-profile-span-2 { grid-column: auto; }
    }
    @page { size: A4; margin: 16mm; }
    @media print {
        .fi-topbar-ctn, .fi-sidebar, .fi-breadcrumbs, .fi-page-header, .fi-page-header-actions, .employee-profile-toolbar { display: none !important; }
        body, .fi-body, .fi-main, .fi-page, .fi-page-content, .fi-main-ctn { background: #fff !important; color: #172033 !important; }
        .fi-main { margin: 0 !important; padding: 0 !important; }
        .employee-profile-page { max-width: none; margin: 0; }
        .employee-profile-document { min-height: 0; padding: 0; border: 0; box-shadow: none; }
        .dp-document-brand { border: 0; border-bottom: 1px solid #cbd5e1; border-radius: 0; background: #fff; }
        .dp-brand-mark { box-shadow: none; }
        .employee-profile-section, .employee-profile-footer, .employee-profile-header { break-inside: avoid; }
        * { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    }
</style>
