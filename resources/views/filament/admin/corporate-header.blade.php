
@php
    $user = auth()->user();
    $routeName = request()->route()?->getName() ?? '';
    $routeParts = explode('.', $routeName);

    $resourceIndex = array_search('resources', $routeParts, true);
    $operation = end($routeParts);

    if ($resourceIndex !== false && isset($routeParts[$resourceIndex + 1])) {
        $resourceName = \Illuminate\Support\Str::headline(
            $routeParts[$resourceIndex + 1]
        );

        $fallbackTitle = match ($operation) {
            'create' => 'Create ' . $resourceName,
            'edit' => 'Edit ' . $resourceName,
            'view' => 'View ' . $resourceName,
            default => $resourceName,
        };
    } else {
        $fallbackTitle = $operation
            ? \Illuminate\Support\Str::headline($operation)
            : 'Dashboard Overview';
    }

    $pageTitle = isset($livewire) && method_exists($livewire, 'getTitle')
        ? ($livewire->getTitle() ?: $fallbackTitle)
        : $fallbackTitle;

    if (in_array($pageTitle, ['Dashboard', 'Dashboard Overview'], true)) {
        $pageTitle = 'Dashboard Overview';
    }

    /*
     * Resolve the icon configured by the current Filament Resource.
     */
    $resourceIcon = null;

    if (
        isset($livewire) &&
        is_object($livewire) &&
        method_exists($livewire, 'getResource')
    ) {
        try {
            $resourceClass = $livewire::getResource();

            if (
                is_string($resourceClass) &&
                class_exists($resourceClass) &&
                method_exists($resourceClass, 'getNavigationIcon')
            ) {
                $resourceIcon = $resourceClass::getNavigationIcon();
            }
        } catch (\Throwable $exception) {
            $resourceIcon = null;
        }
    }

    /*
     * Normalize route and title for automatic icon detection.
     */
    $iconContext = \Illuminate\Support\Str::lower(
        str_replace(
            ['_', '-', '.', '\\', '/'],
            ' ',
            $routeName . ' ' . $pageTitle
        )
    );

    /*
     * Prefer the Resource icon.
     * Otherwise, infer an icon from the current page.
     */
    $pageIcon = $resourceIcon ?: match (true) {
        str_contains($iconContext, 'dashboard'),
        $pageTitle === 'Dashboard Overview' =>
            'heroicon-o-squares-2x2',

        str_contains($iconContext, 'role') =>
            'heroicon-o-shield-check',

        str_contains($iconContext, 'permission'),
        str_contains($iconContext, 'security'),
        str_contains($iconContext, 'access') =>
            'heroicon-o-lock-closed',

        str_contains($iconContext, 'user'),
        str_contains($iconContext, 'member'),
        str_contains($iconContext, 'customer'),
        str_contains($iconContext, 'author') =>
            'heroicon-o-users',

        str_contains($iconContext, 'setting'),
        str_contains($iconContext, 'configuration'),
        str_contains($iconContext, 'preference') =>
            'heroicon-o-cog-6-tooth',

        str_contains($iconContext, 'notification'),
        str_contains($iconContext, 'alert'),
        str_contains($iconContext, 'announcement') =>
            'heroicon-o-bell',

        str_contains($iconContext, 'product'),
        str_contains($iconContext, 'inventory'),
        str_contains($iconContext, 'stock') =>
            'heroicon-o-cube',

        str_contains($iconContext, 'category'),
        str_contains($iconContext, 'folder'),
        str_contains($iconContext, 'group') =>
            'heroicon-o-folder',

        str_contains($iconContext, 'report'),
        str_contains($iconContext, 'analytics'),
        str_contains($iconContext, 'statistic'),
        str_contains($iconContext, 'dashboard chart') =>
            'heroicon-o-chart-bar',

        str_contains($iconContext, 'order'),
        str_contains($iconContext, 'cart'),
        str_contains($iconContext, 'purchase') =>
            'heroicon-o-shopping-cart',

        str_contains($iconContext, 'payment'),
        str_contains($iconContext, 'invoice'),
        str_contains($iconContext, 'finance'),
        str_contains($iconContext, 'transaction') =>
            'heroicon-o-banknotes',

        str_contains($iconContext, 'media'),
        str_contains($iconContext, 'image'),
        str_contains($iconContext, 'photo'),
        str_contains($iconContext, 'gallery') =>
            'heroicon-o-photo',

        str_contains($iconContext, 'document'),
        str_contains($iconContext, 'article'),
        str_contains($iconContext, 'content'),
        str_contains($iconContext, 'page') =>
            'heroicon-o-document-text',

        str_contains($iconContext, 'message'),
        str_contains($iconContext, 'comment'),
        str_contains($iconContext, 'chat'),
        str_contains($iconContext, 'conversation') =>
            'heroicon-o-chat-bubble-left-right',

        str_contains($iconContext, 'email'),
        str_contains($iconContext, 'mail') =>
            'heroicon-o-envelope',

        str_contains($iconContext, 'calendar'),
        str_contains($iconContext, 'event'),
        str_contains($iconContext, 'schedule') =>
            'heroicon-o-calendar-days',

        str_contains($iconContext, 'support'),
        str_contains($iconContext, 'help'),
        str_contains($iconContext, 'ticket') =>
            'heroicon-o-lifebuoy',

        str_contains($iconContext, 'log'),
        str_contains($iconContext, 'activity'),
        str_contains($iconContext, 'history') =>
            'heroicon-o-clock',

        str_contains($iconContext, 'website'),
        str_contains($iconContext, 'web'),
        str_contains($iconContext, 'navigation'),
        str_contains($iconContext, 'menu') =>
            'heroicon-o-globe-alt',

        str_contains($iconContext, 'team'),
        str_contains($iconContext, 'employee'),
        str_contains($iconContext, 'staff') =>
            'heroicon-o-user-group',

        str_contains($iconContext, 'tag'),
        str_contains($iconContext, 'label'),
        str_contains($iconContext, 'coupon'),
        str_contains($iconContext, 'discount') =>
            'heroicon-o-tag',

        str_contains($iconContext, 'location'),
        str_contains($iconContext, 'address'),
        str_contains($iconContext, 'country'),
        str_contains($iconContext, 'city') =>
            'heroicon-o-map-pin',

        str_contains($iconContext, 'database'),
        str_contains($iconContext, 'backup'),
        str_contains($iconContext, 'server') =>
            'heroicon-o-circle-stack',

        default =>
            'heroicon-o-rectangle-stack',
    };

    $userName = $user?->name ?? 'Guest User';

    $userInitial = \Illuminate\Support\Str::upper(
        \Illuminate\Support\Str::substr($userName, 0, 1)
    );

    $userRole = 'Authenticated User';

    if ($user && method_exists($user, 'getRoleNames')) {
        $roles = $user->getRoleNames();

        $userRole = $roles->isNotEmpty()
            ? $roles->implode(', ')
            : 'Authenticated User';
    }
@endphp

<div class="corporate-page-header">
    <div class="corporate-header-glow" aria-hidden="true"></div>

    <div class="corporate-header-content">
        <div class="corporate-breadcrumb">
            <span class="corporate-breadcrumb-home">
                <x-filament::icon
                    icon="heroicon-o-squares-2x2"
                    class="corporate-breadcrumb-icon"
                />
                Dashboard
            </span>

            <x-filament::icon
                icon="heroicon-o-chevron-right"
                class="corporate-breadcrumb-separator"
            />

            <span class="corporate-breadcrumb-current">
                {{ $pageTitle }}
            </span>

            <span class="corporate-admin-badge">
                <span class="corporate-status-dot"></span>
                Admin Panel
            </span>
        </div>

        <div class="corporate-page-heading">
            <div class="corporate-heading-icon">
                <x-filament::icon :icon="$pageIcon" />
            </div>

            <div class="corporate-heading-copy">
                <span class="corporate-heading-eyebrow">
                    DEV-PLATFORM WORKSPACE
                </span>

                <h1>{{ $pageTitle }}</h1>

                <p>
                    {{ $pageTitle === 'Dashboard Overview'
                        ? 'Manage your platform from one central workspace.'
                        : 'Manage and review ' . \Illuminate\Support\Str::lower($pageTitle) . ' in your workspace.' }}
                </p>
            </div>
        </div>

        <div class="corporate-header-footer">
            <span class="corporate-header-accent"></span>

            <span>Dev-Platform Workspace</span>

            <span class="corporate-header-footer-divider"></span>

            <div class="corporate-header-user">
                <div class="corporate-header-avatar">
                    {{ $userInitial }}
                </div>

                <div class="corporate-header-user-copy">
                    <span class="corporate-header-user-name">
                        {{ $userName }}
                    </span>

                    <span class="corporate-header-user-role">
                        {{ $userRole }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
