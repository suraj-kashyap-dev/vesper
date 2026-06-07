<div>
    @php
        $navigation = filament()->getNavigation();
        $isRtl = __('filament-panels::layout.direction') === 'rtl';
        $isSidebarCollapsibleOnDesktop = filament()->isSidebarCollapsibleOnDesktop();
        $isSidebarFullyCollapsibleOnDesktop = filament()->isSidebarFullyCollapsibleOnDesktop();
        $hasTopbar = filament()->hasTopbar();
        $hasTopNavigation = filament()->hasTopNavigation();
        $brandName = config('vesper.branding.name');
        $brandEyebrow = config('vesper.branding.eyebrow', 'Admin Panel');
        $brandMark = config('vesper.branding.mark');
        $sidebarOverviewLabel = config('vesper.sidebar.overview_label', 'Overview');
        $isGlobalSearchInSidebar = filament()->isGlobalSearchEnabled() && filament()->getGlobalSearchPosition() === \Filament\Enums\GlobalSearchPosition::Sidebar;
        $isNotificationsInSidebar = filament()->auth()->check() && filament()->hasDatabaseNotifications() && filament()->getDatabaseNotificationsPosition() === \Filament\Enums\DatabaseNotificationsPosition::Sidebar;
        $isUserMenuInSidebar = filament()->auth()->check() && filament()->hasUserMenu() && filament()->getUserMenuPosition() === \Filament\Enums\UserMenuPosition::Sidebar;

        if (blank($brandName)) {
            $brandName = trim(strip_tags((string) filament()->getBrandName()));
        }

        if (blank($brandMark)) {
            $brandMark = (string) \Illuminate\Support\Str::of($brandName ?: 'Fi')
                ->replaceMatches('/[^A-Za-z0-9]/', '')
                ->substr(0, 2)
                ->upper();
        }
    @endphp

    <aside
        x-data="{}"
        @if ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop)
            x-cloak
        @else
            x-cloak="-lg"
        @endif
        x-bind:class="{
            'fi-sidebar-open': $store.sidebar.isOpen,
            'collapsed': ! $store.sidebar.isOpen,
            'mobile-open': $store.sidebar.isOpen,
        }"
        @class([
            'fi-sidebar',
            'fi-main-sidebar',
            'sidebar',
            'vs-sidebar-top-navigation' => $hasTopNavigation,
        ])
    >
        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_START) }}

        <div class="sb-brand">
            @if ((! $hasTopbar) && $isSidebarCollapsibleOnDesktop)
                <button
                    x-cloak
                    x-data="{}"
                    x-bind:aria-label="$store.sidebar.isOpen ? @js(__('filament-panels::layout.actions.sidebar.collapse.label')) : @js(__('filament-panels::layout.actions.sidebar.expand.label'))"
                    x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                    type="button"
                    class="sb-header-toggle"
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

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_LOGO_BEFORE) }}

            @if ($homeUrl = filament()->getHomeUrl())
                <a
                    {{ \Filament\Support\generate_href_html($homeUrl) }}
                    class="sb-brand-link"
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
                <div class="sb-brand-link">
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

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_LOGO_AFTER) }}

            @if ((! $hasTopbar) && ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop))
                <button
                    x-cloak
                    x-data="{}"
                    x-bind:aria-label="$store.sidebar.isOpen ? @js(__('filament-panels::layout.actions.sidebar.collapse.label')) : @js(__('filament-panels::layout.actions.sidebar.expand.label'))"
                    x-on:click="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                    type="button"
                    class="sb-header-toggle"
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
        </div>

        @if (filament()->hasTenancy() && filament()->hasTenantMenu())
            <div
                @if ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop)
                    x-show="$store.sidebar.isOpen"
                @endif
                class="sb-tenant-menu"
            >
                <x-filament-panels::tenant-menu />
            </div>
        @endif

        @if ($isGlobalSearchInSidebar)
            <div
                @if ($isSidebarCollapsibleOnDesktop || $isSidebarFullyCollapsibleOnDesktop)
                    x-show="$store.sidebar.isOpen"
                @endif
                class="sb-global-search"
            >
                @livewire(Filament\Livewire\GlobalSearch::class)
            </div>
        @endif

        <nav class="fi-sidebar-nav sb-nav">
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_NAV_START) }}

            @foreach ($navigation as $group)
                @php
                    $groupItems = $group->getItems();
                    $groupLabel = $group->getLabel() ?: $sidebarOverviewLabel;
                @endphp

                @if (count($groupItems))
                    <div class="sb-group">
                        <div class="sb-group-label">
                            {{ $groupLabel }}
                        </div>

                        <ul class="fi-sidebar-group-items">
                            @foreach ($groupItems as $item)
                                @php
                                    $isItemChildItemsActive = $item->isChildItemsActive();
                                    $isItemActive = (! $isItemChildItemsActive) && $item->isActive();
                                @endphp

                                <x-filament-panels::sidebar.item
                                    :active="$isItemActive"
                                    :active-child-items="$isItemChildItemsActive"
                                    :active-icon="$item->getActiveIcon()"
                                    :badge="$item->getBadge()"
                                    :badge-color="$item->getBadgeColor()"
                                    :badge-tooltip="$item->getBadgeTooltip()"
                                    :child-items="$item->getChildItems()"
                                    :first="$loop->first"
                                    :icon="$item->getIcon()"
                                    :last="$loop->last"
                                    :should-open-url-in-new-tab="$item->shouldOpenUrlInNewTab()"
                                    :url="$item->getUrl()"
                                    :attributes="\Filament\Support\prepare_inherited_attributes($item->getExtraAttributeBag())"
                                >
                                    {{ $item->getLabel() }}
                                </x-filament-panels::sidebar.item>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach

            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_NAV_END) }}
        </nav>

        @if ($isNotificationsInSidebar || $isUserMenuInSidebar)
            <div class="fi-sidebar-footer sb-user vs-sidebar-footer">
                @if ($isNotificationsInSidebar)
                    @livewire(filament()->getDatabaseNotificationsLivewireComponent(), [
                        'lazy' => filament()->hasLazyLoadedDatabaseNotifications(),
                    ])
                @endif

                @if ($isUserMenuInSidebar)
                    <x-filament-panels::user-menu :position="\Filament\Enums\UserMenuPosition::Sidebar" />
                @endif
            </div>
        @endif

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SIDEBAR_FOOTER) }}
    </aside>

    <x-filament-actions::modals />
</div>
