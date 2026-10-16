
<?php

$descriptions = [
    'Organizations' => 'Manage organization profiles, codes, status, and settings.',
    'Organizational Units' => 'Manage departments, units, and organizational hierarchy.',
    'Memberships' => 'Manage user membership and organization relationships.',
    'Employees' => 'Manage employee records, positions, and organization assignments.',
    'Users' => 'Manage user accounts, status, and account information.',
    'Roles' => 'Manage roles and the access rights assigned to each role.',
    'Permissions' => 'Review and manage system permissions.',
    'Delegations' => 'Manage delegated responsibilities and security access.',
    'Testimonials' => 'Manage website testimonials and their content.',
    'Website Pages' => 'Manage website pages and page content.',
    'Activity Log' => 'Review recorded system activity and audit events.',
];

$groupPresentations = [
    'Access & Security' => [
        'icon' => 'heroicon-o-shield-check',
        'description' => 'Manage security, delegations and access control.',
        'class' => 'security',
    ],
    'Security' => [
        'icon' => 'heroicon-o-lock-closed',
        'description' => 'Control access to protected platform resources.',
        'class' => 'security',
    ],
    'General' => [
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Manage users, roles, permissions and platform features.',
        'class' => 'general',
    ],
    'Organization' => [
        'icon' => 'heroicon-o-building-office-2',
        'description' => 'Manage employees, departments and organizational records.',
        'class' => 'organization',
    ],
    'Security & Audit' => [
        'icon' => 'heroicon-o-clipboard-document-check',
        'description' => 'Review activity logs and maintain system accountability.',
        'class' => 'audit',
    ],
    'Website' => [
        'icon' => 'heroicon-o-globe-alt',
        'description' => 'Manage website pages and published content.',
        'class' => 'website',
    ],
];
?>

<div class="dashboard-module-directory">
    <style>
        .dashboard-module-directory {
            width: 100%;
            min-width: 0;
            color: var(--gray-950, #111827);
        }

        .dashboard-module-directory,
        .dashboard-module-directory * {
            box-sizing: border-box;
        }

        /* Group sections */
        .dashboard-module-directory .module-group {
            width: 100%;
            min-width: 0;
        }

        .dashboard-module-directory .module-group + .module-group {
            margin-top: 1.75rem;
        }

        /* Group banner */
        .dashboard-module-directory .module-group-banner {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            width: 100%;
            min-width: 0;
            margin-bottom: 1rem;
            padding: 1rem 1.1rem;
            color: #fff;
            background: linear-gradient(120deg, #1e3a8a, #2563eb);
            border: 1px solid rgb(255 255 255 / 12%);
            border-radius: 1rem;
            box-shadow: 0 5px 16px rgb(30 58 138 / 12%);
        }

        .dashboard-module-directory .module-group-banner.general {
            background: linear-gradient(120deg, #1e40af, #3b82f6);
        }

        .dashboard-module-directory .module-group-banner.security {
            background: linear-gradient(120deg, #312e81, #6366f1);
        }

        .dashboard-module-directory .module-group-banner.organization {
            background: linear-gradient(120deg, #065f46, #10b981);
        }

        .dashboard-module-directory .module-group-banner.audit {
            background: linear-gradient(120deg, #7c2d12, #ea580c);
        }

        .dashboard-module-directory .module-group-banner.website {
            background: linear-gradient(120deg, #155e75, #0891b2);
        }

        .dashboard-module-directory .module-group-banner-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 3rem;
            width: 3rem;
            height: 3rem;
            color: #fff;
            background: rgb(255 255 255 / 15%);
            border: 1px solid rgb(255 255 255 / 18%);
            border-radius: 0.85rem;
        }

        .dashboard-module-directory .module-group-banner-icon svg {
            width: 1.6rem;
            height: 1.6rem;
        }

        .dashboard-module-directory .module-group-heading {
            flex: 1 1 0;
            min-width: 0;
        }

        .dashboard-module-directory .module-group-title {
            margin: 0;
            color: #fff;
            font-size: 1rem;
            font-weight: 750;
            line-height: 1.5;
            overflow-wrap: break-word;
            word-break: normal;
        }

        .dashboard-module-directory .module-group-description {
            margin: 0.2rem 0 0;
            color: rgb(255 255 255 / 85%);
            font-size: 0.76rem;
            line-height: 1.6;
            overflow-wrap: break-word;
            word-break: normal;
        }

        .dashboard-module-directory .module-group-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            padding: 0.35rem 0.65rem;
            color: #fff;
            background: rgb(255 255 255 / 14%);
            border: 1px solid rgb(255 255 255 / 24%);
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
        }

        /* One full-width card per row on every screen */
        .dashboard-module-directory .module-card-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            align-items: stretch;
            gap: 1rem;
            width: 100%;
            min-width: 0;
        }

        /* Module card */
        .dashboard-module-directory .module-card {
            display: grid;
            grid-template-columns: 2.65rem minmax(0, 1fr);
            align-items: start;
            gap: 0.8rem;
            width: 100%;
            min-width: 0;
            min-height: 8rem;
            padding: 1rem;
            color: inherit;
            text-decoration: none;
            background: var(--module-card-bg, #fff);
            border: 1px solid var(--gray-200, #e5e7eb);
            border-radius: 0.9rem;
            box-shadow: 0 2px 7px rgb(0 0 0 / 3%);
            transition:
                border-color 160ms ease,
                box-shadow 160ms ease,
                transform 160ms ease;
        }

        .dashboard-module-directory .module-card:hover {
            border-color: var(--primary-400, #60a5fa);
            box-shadow: 0 8px 22px rgb(0 0 0 / 7%);
            transform: translateY(-2px);
        }

        .dashboard-module-directory .module-card:focus-visible {
            outline: 2px solid var(--primary-500, #3b82f6);
            outline-offset: 3px;
        }

        .dashboard-module-directory .module-card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 2.65rem;
            width: 2.65rem;
            height: 2.65rem;
            color: var(--primary-600, #2563eb);
            background: var(--primary-50, #eff6ff);
            border-radius: 0.8rem;
        }

        .dashboard-module-directory .module-card-icon svg {
            width: 1.35rem;
            height: 1.35rem;
        }

        .dashboard-module-directory .module-card-content {
            display: flex;
            flex-direction: column;
            align-self: stretch;
            min-width: 0;
            max-width: 100%;
        }

        .dashboard-module-directory .module-card-title {
            display: block;
            margin: 0;
            font-size: 0.9rem;
            font-weight: 750;
            line-height: 1.5;
            overflow-wrap: break-word;
            word-break: normal;
        }

        .dashboard-module-directory .module-card-description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
            margin: 0.3rem 0 0;
            color: var(--gray-500, #6b7280);
            font-size: 0.78rem;
            line-height: 1.6;
            overflow-wrap: break-word;
            word-break: normal;
        }

        .dashboard-module-directory .module-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            min-width: 0;
            margin-top: 0.65rem;
            padding-top: 0.65rem;
            border-top: 1px solid var(--gray-100, #f3f4f6);
        }

        .dashboard-module-directory .module-card-type {
            min-width: 0;
            color: var(--gray-500, #6b7280);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.035em;
            text-transform: uppercase;
            overflow-wrap: break-word;
            word-break: normal;
        }

        .dashboard-module-directory .module-card-arrow {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: var(--gray-400, #9ca3af);
            transition:
                color 160ms ease,
                transform 160ms ease;
        }

        .dashboard-module-directory .module-card-arrow svg {
            width: 1rem;
            height: 1rem;
        }

        .dashboard-module-directory .module-card:hover .module-card-arrow {
            color: var(--primary-600, #2563eb);
            transform: translate(2px, -2px);
        }

        /* Empty state */
        .dashboard-module-directory .module-empty {
            width: 100%;
            padding: 1.5rem;
            color: var(--gray-500, #6b7280);
            text-align: center;
            border: 1px dashed var(--gray-300, #d1d5db);
            border-radius: 1rem;
        }

        /* Dark theme */
        .dark .dashboard-module-directory {
            color: var(--gray-100, #f3f4f6);
        }

        .dark .dashboard-module-directory .module-card {
            --module-card-bg: var(--gray-900, #111827);
            border-color: var(--gray-700, #374151);
            box-shadow: none;
        }

        .dark .dashboard-module-directory .module-card:hover {
            border-color: var(--primary-400, #60a5fa);
            box-shadow: 0 8px 22px rgb(0 0 0 / 18%);
        }

        .dark .dashboard-module-directory .module-card-icon {
            color: var(--primary-300, #93c5fd);
            background: rgb(59 130 246 / 14%);
        }

        .dark .dashboard-module-directory .module-card-description,
        .dark .dashboard-module-directory .module-card-type {
            color: var(--gray-400, #9ca3af);
        }

        .dark .dashboard-module-directory .module-card-footer {
            border-top-color: var(--gray-800, #1f2937);
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .dashboard-module-directory .module-group + .module-group {
                margin-top: 1.5rem;
            }

            .dashboard-module-directory .module-card-grid {
                gap: 0.75rem;
            }

            .dashboard-module-directory .module-card {
                padding: 0.9rem;
            }
        }

        /* Mobile */
        @media (max-width: 640px) {
            .dashboard-module-directory .module-group + .module-group {
                margin-top: 1.25rem;
            }

            .dashboard-module-directory .module-group-banner {
                gap: 0.65rem;
                margin-bottom: 0.75rem;
                padding: 0.8rem;
                border-radius: 0.85rem;
            }

            .dashboard-module-directory .module-group-banner-icon {
                flex-basis: 2.5rem;
                width: 2.5rem;
                height: 2.5rem;
            }

            .dashboard-module-directory .module-group-banner-icon svg {
                width: 1.3rem;
                height: 1.3rem;
            }

            .dashboard-module-directory .module-group-title {
                font-size: 0.9rem;
            }

            .dashboard-module-directory .module-group-description {
                font-size: 0.7rem;
            }

            .dashboard-module-directory .module-group-count {
                padding: 0.25rem 0.45rem;
                font-size: 0.64rem;
            }

            .dashboard-module-directory .module-card-grid {
                gap: 0.6rem;
            }

            .dashboard-module-directory .module-card {
                min-height: 0;
                padding: 0.85rem;
                gap: 0.7rem;
            }

            .dashboard-module-directory .module-card-footer {
                margin-top: 0.55rem;
                padding-top: 0.55rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .dashboard-module-directory .module-card,
            .dashboard-module-directory .module-card-arrow {
                transition: none;
            }

            .dashboard-module-directory .module-card:hover {
                transform: none;
            }
        }
    </style>

    @forelse ($groups as $group => $cards)
        @php
            $presentation = $groupPresentations[$group] ?? [
                'icon' => 'heroicon-o-squares-2x2',
                'description' => 'Explore and manage modules in this section.',
                'class' => 'general',
            ];

            $moduleCount = count($cards);
        @endphp

        <section class="module-group">
            <header class="module-group-banner {{ $presentation['class'] }}">
                <div class="module-group-banner-icon" aria-hidden="true">
                    <x-filament::icon
                        :icon="$presentation['icon']"
                        class="size-6"
                    />
                </div>

                <div class="module-group-heading">
                    <h2 class="module-group-title">
                        {{ $group }}
                    </h2>

                    <p class="module-group-description">
                        {{ $presentation['description'] }}
                    </p>
                </div>

                <span class="module-group-count">
                    {{ $moduleCount }}
                    {{ $moduleCount === 1 ? 'Module' : 'Modules' }}
                </span>
            </header>

            <div class="module-card-grid">
                @foreach ($cards as $card)
                    @php
                        $label = $card['label'] ?? 'Module';
                        $type = $card['type'] ?? 'page';

                        $description = $descriptions[$label]
                            ?? (
                                $type === 'resource'
                                    ? 'View and manage this section of the platform.'
                                    : 'Open this platform page.'
                            );
                    @endphp

                    <a
                        href="{{ $card['url'] }}"
                        class="module-card"
                        aria-label="{{ $label }}"
                    >
                        <div class="module-card-icon" aria-hidden="true">
                            <x-filament::icon
                                :icon="$card['icon']"
                                class="size-5"
                            />
                        </div>

                        <div class="module-card-content">
                            <h3 class="module-card-title">
                                {{ $label }}
                            </h3>

                            <p class="module-card-description">
                                {{ $description }}
                            </p>

                            <div class="module-card-footer">
                                <span class="module-card-type">
                                    {{ $type === 'resource' ? 'Resource' : 'Page' }}
                                </span>

                                <span
                                    class="module-card-arrow"
                                    aria-hidden="true"
                                >
                                    <x-filament::icon
                                        icon="heroicon-m-arrow-up-right"
                                        class="size-4"
                                    />
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @empty
        <div class="module-empty">
            No modules are available for your account.
        </div>
    @endforelse
</div>
