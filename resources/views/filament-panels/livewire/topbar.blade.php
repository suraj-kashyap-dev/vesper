<div class="fi-topbar-ctn">
    @php
        $vesper = \Kashyap\Vesper\VesperPlugin::current();
        $brandName = $vesper?->getBranding('name');
        $brandEyebrow = $vesper?->getBranding('eyebrow') ?? 'Admin Panel';
        $brandMark = $vesper?->getBranding('mark');
        $isRtl = __('filament-panels::layout.direction') === 'rtl';
        $isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
        $isSidebarFullyCollapsibleOnDesktop = filament()->isSidebarFullyCollapsibleOnDesktop();
        $hasNavigation = filament()->hasNavigation();
        $hasTopNavigation = filament()->hasTopNavigation();
        $hasTenancy = filament()->hasTenancy();
        $shouldRenderTopNavigation = $hasTopNavigation || (! $hasNavigation);
        $showDesktopSidebarToggle = (! $hasTopNavigation) && $hasNavigation && ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop);
        $isGlobalSearchInTopbar = filament()->isGlobalSearchEnabled() && filament()->getGlobalSearchPosition() === \Filament\Enums\GlobalSearchPosition::Topbar;
        $isNotificationsInTopbar = filament()->auth()->check() && filament()->hasDatabaseNotifications() && filament()->getDatabaseNotificationsPosition() === \Filament\Enums\DatabaseNotificationsPosition::Topbar;
        $isUserMenuInTopbar = filament()->auth()->check() && filament()->hasUserMenu() && filament()->getUserMenuPosition() === \Filament\Enums\UserMenuPosition::Topbar;
        $hasThemeToggle = filament()->hasDarkMode() && (! filament()->hasDarkModeForced());
        $showThemeToggle = ($vesper?->showThemeToggle() ?? true) && $hasThemeToggle;
        $helpUrl = $vesper?->getHelpUrl();
        $showTenantMenuInNavigation = $shouldRenderTopNavigation && $hasTenancy && filament()->hasTenantMenu();
        $showTenantMenuInActions = (! $shouldRenderTopNavigation) && $hasTenancy && filament()->hasTenantMenu();
        $showSecondaryActions = $isNotificationsInTopbar || filled($helpUrl) || $showTenantMenuInActions;

        if (blank($brandName)) {
            $brandName = trim(strip_tags((string) filament()->getBrandName()));
        }

        if (blank($brandMark)) {
            $brandMark = (string) \Illuminate\Support\Str::of($brandName ?: 'Fi')
                ->replaceMatches('/[^A-Za-z0-9]/', '')
                ->substr(0, 2)
                ->upper();
        }

        $topbarNavigation = \Kashyap\Vesper\Support\TopbarNavigation::resolve();
        $currentLabel = $topbarNavigation['parentLabel']
            ? "{$topbarNavigation['parentLabel']} / {$topbarNavigation['currentLabel']}"
            : $topbarNavigation['currentLabel'];

        $currentIconHtml = \Filament\Support\generate_icon_html(
            $topbarNavigation['currentIcon'],
            attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['vs-topbar-breadcrumb-icon-svg']),
        )?->toHtml();
    @endphp

    <nav
        x-data="{}"
        x-bind:style="window.matchMedia('(min-width: 1024px)').matches && ! @js($hasTopNavigation) ? `margin-inline-start: ${$store.sidebar.isOpen ? 'var(--sidebar-width)' : 'var(--collapsed-sidebar-width)'}; width: calc(100% - ${$store.sidebar.isOpen ? 'var(--sidebar-width)' : 'var(--collapsed-sidebar-width)'});` : ''"
        @class([
            'fi-topbar',
            'vs-topbar',
            'topbar',
            'vs-topbar-has-top-navigation' => $hasTopNavigation,
        ])
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_START) }}

        @if ($hasNavigation)
            <button
                x-cloak
                x-data="{}"
                x-bind:aria-label="$store.sidebar.isOpen ? @js(__('filament-panels::layout.actions.sidebar.collapse.label')) : @js(__('filament-panels::layout.actions.sidebar.expand.label'))"
                x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                type="button"
                class="vs-topbar-mobile-toggle"
            >
                <span x-cloak x-show="! $store.sidebar.isOpen">
                    {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::OutlinedBars3) }}
                </span>

                <span x-cloak x-show="$store.sidebar.isOpen">
                    {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::OutlinedXMark) }}
                </span>
            </button>
        @endif

        <div class="vs-topbar-start">
            @if ($showDesktopSidebarToggle)
                <button
                    x-cloak
                    x-data="{}"
                    x-bind:aria-label="$store.sidebar.isOpen ? @js(__('filament-panels::layout.actions.sidebar.collapse.label')) : @js(__('filament-panels::layout.actions.sidebar.expand.label'))"
                    x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                    type="button"
                    class="vs-topbar-sidebar-toggle"
                >
                    <span x-cloak x-show="! $store.sidebar.isOpen">
                        {{
                            \Filament\Support\generate_icon_html(
                                $isRtl ? \Filament\Support\Icons\Heroicon::OutlinedChevronLeft : \Filament\Support\Icons\Heroicon::OutlinedChevronRight,
                            )
                        }}
                    </span>

                    <span x-cloak x-show="$store.sidebar.isOpen">
                        {{
                            \Filament\Support\generate_icon_html(
                                $isRtl ? \Filament\Support\Icons\Heroicon::OutlinedChevronRight : \Filament\Support\Icons\Heroicon::OutlinedChevronLeft,
                            )
                        }}
                    </span>
                </button>
            @endif

            @if ($shouldRenderTopNavigation)
                <div class="vs-topbar-brand">
                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_LOGO_BEFORE) }}

                    @if ($homeUrl = filament()->getHomeUrl())
                        <a
                            {{ \Filament\Support\generate_href_html($homeUrl) }}
                            class="vs-topbar-brand-link sb-brand-link"
                        >
                            <span class="sb-brand-icon">
                                {{ $brandMark }}
                            </span>

                            <span class="sb-brand-text">
                                <span class="sb-brand-name">
                                    {{ $brandName ?: 'Filament' }}
                                </span>

                                <span class="sb-brand-tag">
                                    {{ $brandEyebrow }}
                                </span>
                            </span>
                        </a>
                    @else
                        <div class="vs-topbar-brand-link sb-brand-link">
                            <span class="sb-brand-icon">
                                {{ $brandMark }}
                            </span>

                            <span class="sb-brand-text">
                                <span class="sb-brand-name">
                                    {{ $brandName ?: 'Filament' }}
                                </span>

                                <span class="sb-brand-tag">
                                    {{ $brandEyebrow }}
                                </span>
                            </span>
                        </div>
                    @endif

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_LOGO_AFTER) }}
                </div>
            @else
                <div class="vs-topbar-breadcrumb topbar-breadcrumb">
                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_LOGO_BEFORE) }}

                    @if ($homeUrl = filament()->getHomeUrl())
                        <a
                            {{ \Filament\Support\generate_href_html($homeUrl) }}
                            class="vs-topbar-breadcrumb-root breadcrumb-item"
                        >
                            {{ $topbarNavigation['brandLabel'] }}
                        </a>
                    @else
                        <span class="vs-topbar-breadcrumb-root breadcrumb-item">
                            {{ $topbarNavigation['brandLabel'] }}
                        </span>
                    @endif

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_LOGO_AFTER) }}

                    <span class="vs-topbar-breadcrumb-separator breadcrumb-sep" aria-hidden="true">
                        {{ \Filament\Support\generate_icon_html($isRtl ? \Filament\Support\Icons\Heroicon::ChevronLeft : \Filament\Support\Icons\Heroicon::ChevronRight) }}
                    </span>

                    <span class="vs-topbar-breadcrumb-current breadcrumb-item current">
                        <span class="vs-topbar-breadcrumb-icon breadcrumb-page-icon" aria-hidden="true">
                            {!! $currentIconHtml !!}
                        </span>

                        <span class="vs-topbar-breadcrumb-label" id="breadcrumb-label">
                            {{ $currentLabel }}
                        </span>
                    </span>
                </div>
            @endif
        </div>

        @if ($shouldRenderTopNavigation)
            <div class="vs-topbar-nav">
                @if ($showTenantMenuInNavigation)
                    <div class="vs-topbar-tenant-menu">
                        <x-filament-panels::tenant-menu teleport />
                    </div>
                @endif

                @if ($hasNavigation)
                    @php
                        $navigation = filament()->getNavigation();
                    @endphp

                    <ul class="fi-topbar-nav-groups vs-topbar-nav-groups">
                        @foreach ($navigation as $group)
                            @php
                                $groupLabel = $group->getLabel();
                                $groupExtraTopbarAttributeBag = $group->getExtraTopbarAttributeBag();
                                $isGroupActive = $group->isActive();
                                $groupIcon = $group->getIcon();
                            @endphp

                            @if ($groupLabel)
                                <x-filament::dropdown
                                    placement="bottom-start"
                                    teleport
                                    :attributes="\Filament\Support\prepare_inherited_attributes($groupExtraTopbarAttributeBag)"
                                >
                                    <x-slot name="trigger">
                                        <x-filament-panels::topbar.item
                                            :active="$isGroupActive"
                                            :icon="$groupIcon"
                                        >
                                            {{ $groupLabel }}
                                        </x-filament-panels::topbar.item>
                                    </x-slot>

                                    @php
                                        $lists = [];

                                        foreach ($group->getItems() as $item) {
                                            if ($childItems = $item->getChildItems()) {
                                                $lists[] = [
                                                    $item,
                                                    ...$childItems,
                                                ];
                                                $lists[] = [];

                                                continue;
                                            }

                                            if (empty($lists)) {
                                                $lists[] = [$item];

                                                continue;
                                            }

                                            $lists[count($lists) - 1][] = $item;
                                        }

                                        if (! empty($lists) && empty($lists[count($lists) - 1])) {
                                            array_pop($lists);
                                        }
                                    @endphp

                                    @foreach ($lists as $list)
                                        <x-filament::dropdown.list>
                                            @foreach ($list as $item)
                                                @php
                                                    $isItemActive = $item->isActive();
                                                    $itemBadge = $item->getBadge();
                                                    $itemBadgeColor = $item->getBadgeColor();
                                                    $itemBadgeTooltip = $item->getBadgeTooltip();
                                                    $itemUrl = $item->getUrl();
                                                    $itemIcon = $isItemActive ? ($item->getActiveIcon() ?? $item->getIcon()) : $item->getIcon();
                                                    $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                                    $itemExtraAttributes = $item->getExtraAttributeBag();
                                                @endphp

                                                <x-filament::dropdown.list.item
                                                    :badge="$itemBadge"
                                                    :badge-color="$itemBadgeColor"
                                                    :badge-tooltip="$itemBadgeTooltip"
                                                    :color="$isItemActive ? 'primary' : 'gray'"
                                                    :href="$itemUrl"
                                                    :icon="$itemIcon"
                                                    tag="a"
                                                    :target="$shouldItemOpenUrlInNewTab ? '_blank' : null"
                                                    :attributes="\Filament\Support\prepare_inherited_attributes($itemExtraAttributes)"
                                                >
                                                    {{ $item->getLabel() }}
                                                </x-filament::dropdown.list.item>
                                            @endforeach
                                        </x-filament::dropdown.list>
                                    @endforeach
                                </x-filament::dropdown>
                            @else
                                @foreach ($group->getItems() as $item)
                                    @php
                                        $isItemActive = $item->isActive();
                                        $itemActiveIcon = $item->getActiveIcon();
                                        $itemBadge = $item->getBadge();
                                        $itemBadgeColor = $item->getBadgeColor();
                                        $itemBadgeTooltip = $item->getBadgeTooltip();
                                        $itemIcon = $item->getIcon();
                                        $shouldItemOpenUrlInNewTab = $item->shouldOpenUrlInNewTab();
                                        $itemUrl = $item->getUrl();
                                        $itemExtraAttributes = $item->getExtraAttributeBag();
                                    @endphp

                                    <x-filament-panels::topbar.item
                                        :active="$isItemActive"
                                        :active-icon="$itemActiveIcon"
                                        :badge="$itemBadge"
                                        :badge-color="$itemBadgeColor"
                                        :badge-tooltip="$itemBadgeTooltip"
                                        :icon="$itemIcon"
                                        :should-open-url-in-new-tab="$shouldItemOpenUrlInNewTab"
                                        :url="$itemUrl"
                                        :attributes="\Filament\Support\prepare_inherited_attributes($itemExtraAttributes)"
                                    >
                                        {{ $item->getLabel() }}
                                    </x-filament-panels::topbar.item>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        @elseif ($isGlobalSearchInTopbar)
            <div class="vs-topbar-search-slot topbar-search">
                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE) }}

                @livewire(Filament\Livewire\GlobalSearch::class)

                {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER) }}
            </div>
        @endif

        <div
            @if ($hasTenancy)
                x-persist="topbar.end.panel-{{ filament()->getId() }}.tenant-{{ filament()->getTenant()?->getKey() }}"
            @else
                x-persist="topbar.end.panel-{{ filament()->getId() }}"
            @endif
            class="fi-topbar-end vs-topbar-end topbar-actions"
        >
            @if ($shouldRenderTopNavigation && $isGlobalSearchInTopbar)
                <div class="vs-topbar-search-slot vs-topbar-search-slot-end topbar-search">
                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE) }}

                    @livewire(Filament\Livewire\GlobalSearch::class)

                    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::GLOBAL_SEARCH_AFTER) }}
                </div>
            @endif

            @if ($showThemeToggle)
                <div
                    x-data="{
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        setTheme(nextTheme) {
                            this.theme = nextTheme
                            localStorage.setItem('theme', nextTheme)
                            window.theme = nextTheme
                            document.documentElement.classList.toggle('dark', nextTheme === 'dark')
                            window.dispatchEvent(new CustomEvent('theme-changed', { detail: nextTheme }))
                        },
                    }"
                    class="vs-topbar-theme-pill theme-pill"
                >
                    <button
                        x-bind:class="{ 'fi-active': theme === 'dark' }"
                        x-on:click="setTheme('dark')"
                        aria-label="{{ __('filament-panels::layout.actions.theme_switcher.dark.label') }}"
                        type="button"
                        class="vs-topbar-theme-option theme-opt"
                    >
                        {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Moon) }}
                    </button>

                    <button
                        x-bind:class="{ 'fi-active': theme === 'light' }"
                        x-on:click="setTheme('light')"
                        aria-label="{{ __('filament-panels::layout.actions.theme_switcher.light.label') }}"
                        type="button"
                        class="vs-topbar-theme-option theme-opt"
                    >
                        {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Sun) }}
                    </button>
                </div>
            @endif

            @if ($showSecondaryActions)
                @if ($showThemeToggle)
                    <span class="vs-topbar-divider tb-divider" aria-hidden="true"></span>
                @endif

                @if ($isNotificationsInTopbar)
                    @livewire(filament()->getDatabaseNotificationsLivewireComponent(), [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                    ])
                @endif

                @if (filled($helpUrl))
                    <a
                        href="{{ $helpUrl }}"
                        target="_blank"
                        rel="noreferrer"
                        class="vs-topbar-action-btn tb-btn"
                    >
                        {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::OutlinedQuestionMarkCircle) }}
                    </a>
                @endif

                @if ($showTenantMenuInActions)
                    <div class="vs-topbar-tenant-menu">
                        <x-filament-panels::tenant-menu teleport />
                    </div>
                @endif
            @endif

            @if ($isUserMenuInTopbar)
                @if ($showThemeToggle || $showSecondaryActions)
                    <span class="vs-topbar-divider tb-divider" aria-hidden="true"></span>
                @endif

                <x-filament-panels::user-menu />
            @endif
        </div>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::TOPBAR_END) }}
    </nav>

    <x-filament-actions::modals />
</div>
