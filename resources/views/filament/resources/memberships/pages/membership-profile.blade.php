@php
    $isRtl = in_array(app()->getLocale(), ['fa', 'ps'], true);
    $labels = $isRtl
        ? [
            'document' => 'پروفایل عضویت سازمانی',
            'subtitle' => 'سند ثبت عضویت و دسترسی سازمانی',
            'reference' => 'شناسه عضویت',
            'issued' => 'تاریخ صدور',
            'membership_status' => 'وضعیت عضویت',
            'member' => 'مشخصات عضو',
            'name' => 'نام کامل',
            'email' => 'ایمیل',
            'invited_email' => 'ایمیل دعوت‌شده',
            'platform_user' => 'حساب کاربری سامانه',
            'organization' => 'سازمان',
            'organization_code' => 'کد سازمان',
            'role' => 'نقش سازمانی',
            'access' => 'سطح دسترسی',
            'membership_details' => 'جزئیات عضویت',
            'joined' => 'تاریخ پیوستن',
            'accepted' => 'تاریخ پذیرش دعوت',
            'invited' => 'تاریخ ارسال دعوت',
            'expires' => 'انقضای دعوت',
            'invite_status' => 'وضعیت دعوت',
            'notes' => 'توضیحات',
            'verification' => 'تأیید سازمان',
            'representative' => 'نماینده مجاز',
            'signature' => 'امضا',
            'seal' => 'مهر',
            'generated' => 'این سند به‌صورت سیستمی تولید شده و براساس اطلاعات ثبت‌شده در سامانه است.',
            'not_provided' => 'ثبت نشده',
            'member_number' => 'عضو سازمان',
        ]
        : [
            'document' => 'Organization Membership Profile',
            'subtitle' => 'Organization membership and access record',
            'reference' => 'Membership reference',
            'issued' => 'Date issued',
            'membership_status' => 'Membership status',
            'member' => 'Member details',
            'name' => 'Full name',
            'email' => 'Email address',
            'invited_email' => 'Invited email',
            'platform_user' => 'Platform account',
            'organization' => 'Organization',
            'organization_code' => 'Organization code',
            'role' => 'Organization role',
            'access' => 'Access level',
            'membership_details' => 'Membership details',
            'joined' => 'Date joined',
            'accepted' => 'Invitation accepted',
            'invited' => 'Invitation sent',
            'expires' => 'Invitation expires',
            'invite_status' => 'Invitation status',
            'notes' => 'Notes',
            'verification' => 'Organization verification',
            'representative' => 'Authorized representative',
            'signature' => 'Signature',
            'seal' => 'Official seal',
            'generated' => 'System-generated profile based on information maintained in this platform.',
            'not_provided' => 'Not provided',
            'member_number' => 'Organization member',
        ];

    $value = fn ($item): string => filled($item) ? (string) $item : $labels['not_provided'];
    $statusLabel = match ($membership->status) {
        'active' => $isRtl ? 'فعال' : 'Active',
        'inactive' => $isRtl ? 'غیرفعال' : 'Inactive',
        'suspended' => $isRtl ? 'معلق' : 'Suspended',
        'invited' => $isRtl ? 'در انتظار پذیرش' : 'Invitation pending',
        'revoked' => $isRtl ? 'لغوشده' : 'Revoked',
        default => ucfirst((string) $membership->status),
    };
    $roleLabel = match ($membership->role) {
        'owner' => $isRtl ? 'مالک' : 'Owner',
        'admin' => $isRtl ? 'مدیر' : 'Administrator',
        'member' => $isRtl ? 'عضو' : 'Member',
        'viewer' => $isRtl ? 'مشاهده‌گر' : 'Viewer',
        default => str($membership->role)->replace('_', ' ')->title(),
    };
    $isInvitation = in_array($membership->status, ['invited', 'revoked'], true);
@endphp

<div class="membership-profile-page" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    @if (! ($hideProfileToolbar ?? false))
        <div class="membership-profile-toolbar">
            <a href="{{ $editUrl }}" class="membership-profile-button">
                {{ $isRtl ? 'ویرایش عضویت' : 'Edit membership' }}
            </a>
            <button type="button" class="membership-profile-button" wire:click="downloadPdf" wire:loading.attr="disabled" wire:target="downloadPdf">
                {{ $isRtl ? 'دانلود PDF' : 'Download PDF' }}
            </button>
            <button type="button" class="membership-profile-button membership-profile-print" onclick="window.print()">
                {{ $isRtl ? 'چاپ / ذخیره PDF' : 'Print / Save as PDF' }}
            </button>
        </div>
    @endif

    <article class="membership-profile-document">
        <div class="dp-document-brand">
            <div class="dp-brand-mark" aria-hidden="true"><span>DP</span><i></i></div>
            <div class="dp-brand-copy">
                <strong>Dev-Platform</strong>
                <span>{{ $isRtl ? 'سامانه مدیریت سازمانی' : 'Enterprise Management System' }}</span>
            </div>
            <span class="dp-brand-caption">{{ $isRtl ? 'سند عضویت' : 'MEMBERSHIP RECORD' }}</span>
        </div>

        <header class="membership-profile-header">
            <div class="membership-profile-identity">
                @if ($userAvatarUrl)
                    <img src="{{ $userAvatarUrl }}" alt="{{ $membership->user?->name }}" class="membership-profile-avatar">
                @else
                    <div class="membership-profile-avatar membership-profile-avatar-fallback" aria-hidden="true">
                        {{ $membership->user?->name
                            ? \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($membership->user->name, 0, 1))
                            : 'M' }}
                    </div>
                @endif

                <div>
                    <p class="membership-profile-kicker">{{ $labels['subtitle'] }}</p>
                    <h1>{{ $labels['document'] }}</h1>
                    <p class="membership-profile-name">
                        {{ $membership->user?->name ?? $membership->invite_email ?? $labels['member_number'] }}
                    </p>
                    <p class="membership-profile-organization-name">{{ $membership->organization?->name }}</p>
                </div>
            </div>

            <div class="membership-profile-reference">
                <div><span>{{ $labels['reference'] }}</span><strong>MEM-{{ str_pad((string) $membership->getKey(), 6, '0', STR_PAD_LEFT) }}</strong></div>
                <div><span>{{ $labels['issued'] }}</span><strong>{{ $issuedAt->format('Y-m-d') }}</strong></div>
                <div>
                    <span>{{ $labels['membership_status'] }}</span>
                    <strong class="membership-profile-status membership-profile-status-{{ $membership->status }}">{{ $statusLabel }}</strong>
                </div>
            </div>
        </header>

        <section class="membership-profile-section">
            <h2>{{ $labels['member'] }}</h2>
            <dl class="membership-profile-grid">
                <div><dt>{{ $labels['name'] }}</dt><dd>{{ $value($membership->user?->name) }}</dd></div>
                <div><dt>{{ $isInvitation ? $labels['invited_email'] : $labels['email'] }}</dt><dd>{{ $value($membership->user?->email ?? $membership->invite_email) }}</dd></div>
                <div class="membership-profile-span-2"><dt>{{ $labels['platform_user'] }}</dt><dd>{{ $membership->user ? $membership->user->name . ' · ' . $membership->user->email : $labels['not_provided'] }}</dd></div>
            </dl>
        </section>

        <section class="membership-profile-section">
            <h2>{{ $labels['organization'] }}</h2>
            <dl class="membership-profile-grid membership-profile-org-grid">
                <div class="membership-profile-org-name">
                    @if ($organizationLogoUrl)
                        <img src="{{ $organizationLogoUrl }}" alt="{{ $membership->organization?->name }}" class="membership-profile-org-logo">
                    @else
                        <span class="membership-profile-org-logo membership-profile-org-fallback" aria-hidden="true">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($membership->organization?->name ?? 'O', 0, 1)) }}
                        </span>
                    @endif
                    <div><dt>{{ $labels['organization'] }}</dt><dd>{{ $value($membership->organization?->name) }}</dd></div>
                </div>
                <div><dt>{{ $labels['organization_code'] }}</dt><dd>{{ $value($membership->organization?->code) }}</dd></div>
                <div><dt>{{ $labels['role'] }}</dt><dd><span class="membership-profile-role">{{ $roleLabel }}</span></dd></div>
                <div><dt>{{ $labels['access'] }}</dt><dd>{{ $roleLabel }}</dd></div>
            </dl>
        </section>

        <section class="membership-profile-section">
            <h2>{{ $labels['membership_details'] }}</h2>
            <dl class="membership-profile-grid">
                <div><dt>{{ $labels['membership_status'] }}</dt><dd>{{ $statusLabel }}</dd></div>
                <div><dt>{{ $labels['joined'] }}</dt><dd>{{ $membership->joined_at?->timezone($membership->organization?->timezone ?: config('app.timezone'))->format('Y-m-d H:i') ?? $labels['not_provided'] }}</dd></div>
                @if ($membership->invited_at)
                    <div><dt>{{ $labels['invited'] }}</dt><dd>{{ $membership->invited_at->timezone($membership->organization?->timezone ?: config('app.timezone'))->format('Y-m-d H:i') }}</dd></div>
                @endif
                @if ($membership->accepted_at)
                    <div><dt>{{ $labels['accepted'] }}</dt><dd>{{ $membership->accepted_at->timezone($membership->organization?->timezone ?: config('app.timezone'))->format('Y-m-d H:i') }}</dd></div>
                @endif
                @if ($membership->invitation_expires_at)
                    <div><dt>{{ $labels['expires'] }}</dt><dd>{{ $membership->invitation_expires_at->timezone($membership->organization?->timezone ?: config('app.timezone'))->format('Y-m-d H:i') }}</dd></div>
                @endif
                @if ($isInvitation)
                    <div><dt>{{ $labels['invite_status'] }}</dt><dd>{{ $statusLabel }}</dd></div>
                @endif
            </dl>
        </section>

        @if (filled($membership->organization?->description))
            <section class="membership-profile-section">
                <h2>{{ $labels['notes'] }}</h2>
                <p class="membership-profile-notes">{{ $membership->organization->description }}</p>
            </section>
        @endif

        <footer class="membership-profile-footer">
            <h2>{{ $labels['verification'] }}</h2>
            <div class="membership-profile-signatures">
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
    .membership-profile-page { max-width: 980px; margin: 1.5rem auto; color: #172033; }
    .membership-profile-toolbar { display: flex; justify-content: flex-end; gap: .75rem; margin-bottom: 1rem; }
    .membership-profile-button { border: 1px solid #cbd5e1; border-radius: .5rem; padding: .6rem 1rem; background: #fff; color: #172033; font-weight: 600; text-decoration: none; cursor: pointer; }
    .membership-profile-print { border-color: #17365d; background: #17365d; color: #fff; }
    .membership-profile-document { min-height: 980px; padding: 2.25rem; border: 1px solid #cbd5e1; background: #fff; box-shadow: 0 12px 35px rgb(15 23 42 / 10%); }
    .membership-profile-header { display: flex; justify-content: space-between; gap: 2rem; padding-bottom: 1.5rem; border-bottom: 3px solid #17365d; }
    .membership-profile-identity { display: flex; align-items: center; gap: 1.15rem; }
    .membership-profile-avatar { width: 6rem; height: 6rem; flex: 0 0 6rem; object-fit: cover; border: 2px solid #dbe3ec; border-radius: 50%; }
    .membership-profile-avatar-fallback { display: grid; place-items: center; background: #eff6ff; color: #17365d; font-size: 1.8rem; font-weight: 750; }
    .membership-profile-kicker { margin: 0 0 .35rem; color: #64748b; font-size: .72rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; }
    .membership-profile-header h1 { margin: 0; color: #17365d; font-size: 1.55rem; font-weight: 800; }
    .membership-profile-name { margin: .35rem 0 0; color: #172033; font-size: 1.1rem; font-weight: 700; }
    .membership-profile-organization-name { margin: .15rem 0 0; color: #64748b; font-size: .85rem; }
    .membership-profile-reference { min-width: 205px; display: grid; align-content: center; gap: .55rem; }
    .membership-profile-reference div { display: flex; justify-content: space-between; gap: .75rem; font-size: .72rem; }
    .membership-profile-reference span, .membership-profile-section dt { color: #64748b; }
    .membership-profile-reference strong { text-align: end; }
    .membership-profile-status-active { color: #15803d; }
    .membership-profile-status-invited { color: #a16207; }
    .membership-profile-status-inactive, .membership-profile-status-suspended, .membership-profile-status-revoked { color: #b91c1c; }
    .membership-profile-section { margin-top: 1.5rem; break-inside: avoid; }
    .membership-profile-section h2, .membership-profile-footer h2 { margin: 0 0 .8rem; padding-bottom: .4rem; border-bottom: 1px solid #dbe3ec; color: #17365d; font-size: .95rem; font-weight: 750; }
    .membership-profile-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .85rem 1.5rem; margin: 0; }
    .membership-profile-grid > div { min-width: 0; }
    .membership-profile-grid dt { margin-bottom: .2rem; font-size: .7rem; font-weight: 650; }
    .membership-profile-grid dd { margin: 0; overflow-wrap: anywhere; font-size: .85rem; font-weight: 550; }
    .membership-profile-span-2 { grid-column: span 2; }
    .membership-profile-org-name { display: flex; align-items: center; gap: .65rem; }
    .membership-profile-org-logo { width: 2.5rem; height: 2.5rem; flex: 0 0 2.5rem; object-fit: contain; border: 1px solid #dbe3ec; border-radius: .45rem; }
    .membership-profile-org-fallback { display: grid; place-items: center; background: #f1f5f9; color: #17365d; font-weight: 750; }
    .membership-profile-org-name div { display: grid; gap: .2rem; }
    .membership-profile-role { display: inline-block; padding: .2rem .55rem; border: 1px solid #dbe5f0; border-radius: 999px; background: #f1f5f9; color: #17365d; font-size: .75rem; font-weight: 700; }
    .membership-profile-notes { margin: 0; color: #334155; font-size: .85rem; line-height: 1.7; white-space: pre-line; }
    .membership-profile-footer { margin-top: 2rem; break-inside: avoid; }
    .membership-profile-signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; padding: 1rem .5rem .5rem; }
    .membership-profile-signatures div { display: grid; min-height: 95px; align-content: space-between; color: #475569; font-size: .75rem; }
    .membership-profile-signatures i { display: block; border-bottom: 1px solid #94a3b8; }
    .membership-profile-signatures small { padding-top: .25rem; color: #64748b; }
    .membership-profile-footer > p { margin: .75rem 0 0; color: #64748b; font-size: .68rem; text-align: center; }
    [dir="rtl"] .membership-profile-reference div { flex-direction: row-reverse; }
    [dir="rtl"] .membership-profile-reference strong { text-align: start; }
    @media (max-width: 700px) {
        .dp-brand-caption { max-width: 7rem; text-align: center; }
        .membership-profile-document { min-height: 0; padding: 1.25rem; }
        .membership-profile-header { flex-direction: column; gap: 1rem; }
        .membership-profile-grid { grid-template-columns: 1fr; }
        .membership-profile-span-2 { grid-column: auto; }
    }
    @page { size: A4; margin: 16mm; }
    @media print {
        .fi-topbar-ctn, .fi-sidebar, .fi-breadcrumbs, .fi-page-header, .fi-page-header-actions, .membership-profile-toolbar { display: none !important; }
        body, .fi-body, .fi-main, .fi-page, .fi-page-content, .fi-main-ctn { background: #fff !important; color: #172033 !important; }
        .fi-main { margin: 0 !important; padding: 0 !important; }
        .membership-profile-page { max-width: none; margin: 0; }
        .membership-profile-document { min-height: 0; padding: 0; border: 0; box-shadow: none; }
        .dp-document-brand { border: 0; border-bottom: 1px solid #cbd5e1; border-radius: 0; background: #fff; }
        .membership-profile-section, .membership-profile-footer, .membership-profile-header { break-inside: avoid; }
        * { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
    }
</style>
