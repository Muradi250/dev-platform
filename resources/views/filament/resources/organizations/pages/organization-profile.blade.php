@php
    $isRtl = in_array($organization->default_locale, ['fa', 'ps'], true);
    $labels = $isRtl
        ? [
            'document' => 'پروفایل رسمی سازمان',
            'subtitle' => 'سند اطلاعات ثبت‌شده در سامانه',
            'registration' => 'شناسه سند',
            'issued' => 'تاریخ صدور',
            'status' => 'وضعیت',
            'identity' => 'مشخصات سازمان',
            'name' => 'نام سازمان',
            'code' => 'کد سازمان',
            'type' => 'نوع سازمان',
            'legal_type' => 'نوع شخصیت حقوقی',
            'registration_number' => 'شماره ثبت',
            'tax_id' => 'شناسه مالیاتی',
            'address' => 'نشانی رسمی',
            'address_line_1' => 'نشانی',
            'address_line_2' => 'ادامه نشانی',
            'city' => 'شهر',
            'region' => 'استان / منطقه',
            'country' => 'کشور',
            'postal_code' => 'کد پستی',
            'contact' => 'اطلاعات تماس',
            'primary_contact' => 'مسئول تماس',
            'email' => 'ایمیل',
            'phone' => 'تلفن',
            'website' => 'وب‌سایت',
            'settings' => 'تنظیمات سازمان',
            'locale' => 'زبان پیش‌فرض',
            'timezone' => 'منطقه زمانی',
            'currency' => 'واحد پول',
            'description' => 'معرفی سازمان',
            'summary' => 'خلاصه سازمان',
            'members' => 'اعضای فعال',
            'units' => 'واحدهای سازمانی',
            'employees' => 'کارمندان',
            'authorized' => 'تأیید و مهر سازمان',
            'representative' => 'نماینده مجاز',
            'signature' => 'امضا',
            'seal' => 'مهر',
            'generated' => 'این سند به‌صورت سیستمی تولید شده است. اعتبار اطلاعات منوط به سوابق ثبت‌شده در سامانه است.',
            'not_found' => 'ثبت نشده',
        ]
        : [
            'document' => 'Organization Profile',
            'subtitle' => 'Official record maintained in the platform',
            'registration' => 'Document reference',
            'issued' => 'Date issued',
            'status' => 'Status',
            'identity' => 'Organization identity',
            'name' => 'Organization name',
            'code' => 'Organization code',
            'type' => 'Organization type',
            'legal_type' => 'Legal entity type',
            'registration_number' => 'Registration number',
            'tax_id' => 'Tax identification number',
            'address' => 'Registered address',
            'address_line_1' => 'Address line 1',
            'address_line_2' => 'Address line 2',
            'city' => 'City',
            'region' => 'State / Province / Region',
            'country' => 'Country',
            'postal_code' => 'Postal code',
            'contact' => 'Contact information',
            'primary_contact' => 'Primary contact',
            'email' => 'Email',
            'phone' => 'Phone',
            'website' => 'Website',
            'settings' => 'Organization settings',
            'locale' => 'Default language',
            'timezone' => 'Time zone',
            'currency' => 'Currency',
            'description' => 'Organization overview',
            'summary' => 'Organization summary',
            'members' => 'Active members',
            'units' => 'Organizational units',
            'employees' => 'Employees',
            'authorized' => 'Authorization and seal',
            'representative' => 'Authorized representative',
            'signature' => 'Signature',
            'seal' => 'Official seal',
            'generated' => 'System-generated profile. Information is based on records maintained in this platform.',
            'not_found' => 'Not provided',
        ];

    $value = fn ($item): string => filled($item) ? (string) $item : $labels['not_found'];
    $statusLabel = match ($organization->status) {
        'active' => $isRtl ? 'فعال' : 'Active',
        'inactive' => $isRtl ? 'غیرفعال' : 'Inactive',
        'suspended' => $isRtl ? 'تعلیق‌شده' : 'Suspended',
        default => ucfirst((string) $organization->status),
    };
@endphp

<div class="org-profile-page" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    @if (! ($hideProfileToolbar ?? false))
        <div class="org-profile-toolbar">
            <a href="{{ $editUrl }}" class="org-profile-edit">
                {{ $isRtl ? 'ویرایش اطلاعات' : 'Edit organization' }}
            </a>
            <button type="button" wire:click="downloadPdf" wire:loading.attr="disabled" wire:target="downloadPdf">
                {{ $isRtl ? 'دانلود PDF' : 'Download PDF' }}
            </button>
            <button type="button" class="org-profile-print" onclick="window.print()">
                {{ $isRtl ? 'چاپ / ذخیره PDF' : 'Print / Save as PDF' }}
            </button>
        </div>
    @endif

    <article class="org-profile-document">
        <div class="dp-document-brand">
            <div class="dp-brand-mark" aria-hidden="true"><span>DP</span><i></i></div>
            <div class="dp-brand-copy">
                <strong>Dev-Platform</strong>
                <span>{{ $isRtl ? 'سامانه مدیریت سازمانی' : 'Enterprise Management System' }}</span>
            </div>
            <span class="dp-brand-caption">{{ $isRtl ? 'پروفایل سازمانی' : 'ORGANIZATION RECORD' }}</span>
        </div>

        <header class="org-profile-header">
            <div class="org-profile-brand">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $organization->name }}" class="org-profile-logo">
                @else
                    <div class="org-profile-logo-fallback" aria-hidden="true">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($organization->name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <p class="org-profile-kicker">{{ $labels['subtitle'] }}</p>
                    <h1>{{ $labels['document'] }}</h1>
                    <p class="org-profile-org-name">{{ $organization->name }}</p>
                </div>
            </div>

            <div class="org-profile-reference">
                <div>
                    <span>{{ $labels['registration'] }}</span>
                    <strong>{{ $organization->code }}</strong>
                </div>
                <div>
                    <span>{{ $labels['issued'] }}</span>
                    <strong>{{ $issuedAt->format('Y-m-d') }}</strong>
                </div>
                <div>
                    <span>{{ $labels['status'] }}</span>
                    <strong class="org-profile-status org-profile-status-{{ $organization->status }}">
                        {{ $statusLabel }}
                    </strong>
                </div>
            </div>
        </header>

        <section class="org-profile-section">
            <h2>{{ $labels['identity'] }}</h2>
            <dl class="org-profile-grid">
                <div><dt>{{ $labels['name'] }}</dt><dd>{{ $value($organization->name) }}</dd></div>
                <div><dt>{{ $labels['code'] }}</dt><dd>{{ $value($organization->code) }}</dd></div>
                <div><dt>{{ $labels['type'] }}</dt><dd>{{ $value($organization->type) }}</dd></div>
                <div><dt>{{ $labels['legal_type'] }}</dt><dd>{{ $value($organization->legal_type) }}</dd></div>
                <div><dt>{{ $labels['registration_number'] }}</dt><dd>{{ $value($organization->registration_number) }}</dd></div>
                <div><dt>{{ $labels['tax_id'] }}</dt><dd>{{ $value($organization->tax_id) }}</dd></div>
            </dl>
        </section>

        <section class="org-profile-section">
            <h2>{{ $labels['address'] }}</h2>
            <dl class="org-profile-grid">
                <div class="org-profile-span-2"><dt>{{ $labels['address_line_1'] }}</dt><dd>{{ $value($organization->address_line_1) }}</dd></div>
                <div class="org-profile-span-2"><dt>{{ $labels['address_line_2'] }}</dt><dd>{{ $value($organization->address_line_2) }}</dd></div>
                <div><dt>{{ $labels['city'] }}</dt><dd>{{ $value($organization->city) }}</dd></div>
                <div><dt>{{ $labels['region'] }}</dt><dd>{{ $value($organization->region) }}</dd></div>
                <div><dt>{{ $labels['country'] }}</dt><dd>{{ $value($organization->country) }}</dd></div>
                <div><dt>{{ $labels['postal_code'] }}</dt><dd>{{ $value($organization->postal_code) }}</dd></div>
            </dl>
        </section>

        <section class="org-profile-section">
            <h2>{{ $labels['contact'] }}</h2>
            <dl class="org-profile-grid">
                <div><dt>{{ $labels['primary_contact'] }}</dt><dd>{{ $value($organization->primary_contact_name) }}</dd></div>
                <div><dt>{{ $labels['email'] }}</dt><dd>{{ $value($organization->primary_contact_email ?: $organization->email) }}</dd></div>
                <div><dt>{{ $labels['phone'] }}</dt><dd>{{ $value($organization->primary_contact_phone ?: $organization->phone) }}</dd></div>
                <div><dt>{{ $labels['website'] }}</dt><dd>{{ $value($organization->website) }}</dd></div>
            </dl>
        </section>

        <section class="org-profile-section">
            <h2>{{ $labels['settings'] }}</h2>
            <dl class="org-profile-grid">
                <div><dt>{{ $labels['locale'] }}</dt><dd>{{ $value($organization->default_locale) }}</dd></div>
                <div><dt>{{ $labels['timezone'] }}</dt><dd>{{ $value($organization->timezone) }}</dd></div>
                <div><dt>{{ $labels['currency'] }}</dt><dd>{{ $value($organization->currency) }}</dd></div>
            </dl>
        </section>

        @if (filled($organization->description))
            <section class="org-profile-section">
                <h2>{{ $labels['description'] }}</h2>
                <p class="org-profile-description">{{ $organization->description }}</p>
            </section>
        @endif

        <section class="org-profile-section">
            <h2>{{ $labels['summary'] }}</h2>
            <div class="org-profile-stats">
                <div><strong>{{ number_format($organization->active_members_count) }}</strong><span>{{ $labels['members'] }}</span></div>
                <div><strong>{{ number_format($organization->organizational_units_count) }}</strong><span>{{ $labels['units'] }}</span></div>
                <div><strong>{{ number_format($organization->employees_count) }}</strong><span>{{ $labels['employees'] }}</span></div>
            </div>
        </section>

        <footer class="org-profile-footer">
            <h2>{{ $labels['authorized'] }}</h2>
            <div class="org-profile-signatures">
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
    .org-profile-page { max-width: 980px; margin: 1.5rem auto; color: #172033; }
    .org-profile-toolbar { display: flex; justify-content: flex-end; gap: .75rem; margin-bottom: 1rem; }
    .org-profile-toolbar a, .org-profile-toolbar button { border: 1px solid #cbd5e1; border-radius: .5rem; padding: .6rem 1rem; background: #fff; color: #172033; font-weight: 600; text-decoration: none; cursor: pointer; }
    .org-profile-toolbar .org-profile-print { border-color: #17365d; background: #17365d; color: #fff; }
    .org-profile-document { position: relative; min-height: 1050px; padding: 2.25rem; border: 1px solid #cbd5e1; background: #fff; box-shadow: 0 12px 35px rgb(15 23 42 / 10%); }
    .org-profile-header { display: flex; justify-content: space-between; gap: 2rem; padding-bottom: 1.5rem; border-bottom: 3px solid #17365d; }
    .org-profile-brand { display: flex; align-items: center; gap: 1rem; }
    .org-profile-logo, .org-profile-logo-fallback { width: 5rem; height: 5rem; flex: 0 0 5rem; object-fit: contain; border: 1px solid #dbe3ec; border-radius: .6rem; }
    .org-profile-logo-fallback { display: grid; place-items: center; background: #f1f5f9; color: #17365d; font-size: 2rem; font-weight: 700; }
    .org-profile-kicker { margin: 0 0 .35rem; color: #64748b; font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .org-profile-header h1 { margin: 0; color: #17365d; font-size: 1.65rem; font-weight: 800; }
    .org-profile-org-name { margin: .35rem 0 0; color: #334155; font-size: 1rem; font-weight: 600; }
    .org-profile-reference { min-width: 175px; display: grid; align-content: center; gap: .55rem; }
    .org-profile-reference div { display: flex; justify-content: space-between; gap: .75rem; font-size: .75rem; }
    .org-profile-reference span, .org-profile-section dt { color: #64748b; }
    .org-profile-reference strong { text-align: end; }
    .org-profile-status-active { color: #15803d; }
    .org-profile-status-inactive, .org-profile-status-suspended { color: #b91c1c; }
    .org-profile-section { margin-top: 1.4rem; break-inside: avoid; }
    .org-profile-section h2, .org-profile-footer h2 { margin: 0 0 .75rem; padding-bottom: .4rem; border-bottom: 1px solid #dbe3ec; color: #17365d; font-size: .95rem; font-weight: 750; }
    .org-profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .75rem 1.5rem; margin: 0; }
    .org-profile-grid > div { min-width: 0; }
    .org-profile-grid dt { margin-bottom: .2rem; font-size: .7rem; font-weight: 650; }
    .org-profile-grid dd { margin: 0; overflow-wrap: anywhere; font-size: .85rem; font-weight: 550; }
    .org-profile-span-2 { grid-column: span 2; }
    .org-profile-description { margin: 0; color: #334155; font-size: .85rem; line-height: 1.7; white-space: pre-line; }
    .org-profile-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: .75rem; }
    .org-profile-stats div { display: grid; gap: .2rem; padding: .8rem; border: 1px solid #dbe3ec; border-radius: .5rem; text-align: center; }
    .org-profile-stats strong { color: #17365d; font-size: 1.15rem; }
    .org-profile-stats span { color: #64748b; font-size: .72rem; }
    .org-profile-footer { margin-top: 1.6rem; break-inside: avoid; }
    .org-profile-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 1rem .5rem .5rem; }
    .org-profile-signatures div { display: grid; min-height: 95px; align-content: space-between; color: #475569; font-size: .75rem; }
    .org-profile-signatures i { display: block; border-bottom: 1px solid #94a3b8; }
    .org-profile-signatures small { padding-top: .25rem; color: #64748b; }
    .org-profile-footer > p { margin: .75rem 0 0; color: #64748b; font-size: .68rem; text-align: center; }
    [dir="rtl"] .org-profile-reference div { flex-direction: row-reverse; }
    [dir="rtl"] .org-profile-reference strong { text-align: start; }
    @media (max-width: 700px) {
        .dp-brand-caption { max-width: 7rem; text-align: center; }
        .org-profile-document { min-height: 0; padding: 1.25rem; }
        .org-profile-header { flex-direction: column; gap: 1rem; }
        .org-profile-grid { grid-template-columns: 1fr; }
        .org-profile-span-2 { grid-column: auto; }
    }
    @page { size: A4; margin: 16mm; }
    @media print {
        .fi-topbar-ctn, .fi-sidebar, .fi-breadcrumbs, .fi-page-header, .fi-page-header-actions, .org-profile-toolbar { display: none !important; }
        body, .fi-body, .fi-main, .fi-page, .fi-page-content, .fi-main-ctn { background: #fff !important; color: #172033 !important; }
        .fi-main { margin: 0 !important; padding: 0 !important; }
        .org-profile-page { max-width: none; margin: 0; }
        .org-profile-document { min-height: 0; padding: 0; border: 0; box-shadow: none; }
        .dp-document-brand { border: 0; border-bottom: 1px solid #cbd5e1; border-radius: 0; background: #fff; }
        .dp-brand-mark { box-shadow: none; }
        .org-profile-section, .org-profile-footer, .org-profile-header { break-inside: avoid; }
        a { color: inherit; text-decoration: none; }
        * { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    }
</style>
