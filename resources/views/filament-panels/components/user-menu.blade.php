@props([
    'position' => null,
])

@php
    $user = filament()->auth()->user();
    $items = $this->getUserMenuItems();

    $itemsBeforeAndAfterThemeSwitcher = collect($items)
        ->groupBy(fn (\Filament\Actions\Action $item): bool => $item->getSort() < 0, preserveKeys: true)
        ->all();
    $itemsBeforeThemeSwitcher = $itemsBeforeAndAfterThemeSwitcher[true] ?? collect();
    $itemsAfterThemeSwitcher = $itemsBeforeAndAfterThemeSwitcher[false] ?? collect();

    $position ??= filament()->getUserMenuPosition();
    $userName = filament()->getUserName($user);
    $userEmail = data_get($user, 'email');
    $userRole = data_get($user, 'role')
        ?? data_get($user, 'role.name')
        ?? \Kashyap\Vesper\VesperPlugin::current()?->getSidebar('user_role')
        ?? 'Administrator';
@endphp

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_BEFORE) }}

<x-filament::dropdown
    :placement="($position === \Filament\Enums\UserMenuPosition::Topbar) ? 'bottom-end' : 'top-end'"
    :teleport="$position === \Filament\Enums\UserMenuPosition::Topbar"
    :attributes="
        \Filament\Support\prepare_inherited_attributes($attributes)
            ->class([
                'fi-user-menu',
                'vs-user-menu',
                'tb-dropdown' => $position === \Filament\Enums\UserMenuPosition::Topbar,
            ])
    "
>
    <x-slot name="trigger">
        @if ($position === \Filament\Enums\UserMenuPosition::Sidebar)
            <button
                aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}"
                type="button"
                class="sb-user-card"
            >
                <span class="sb-avatar sb-online">
                    <x-filament-panels::avatar.user :user="$user" loading="lazy" class="sb-avatar-image" />
                </span>

                <span class="sb-user-info">
                    <span class="sb-user-name">
                        {{ $userName }}
                    </span>

                    <span class="sb-user-role">
                        {{ $userRole }}
                    </span>
                </span>

                <span class="sb-user-dots" aria-hidden="true">
                    &hellip;
                </span>
            </button>
        @else
            <button
                aria-label="{{ __('filament-panels::layout.actions.open_user_menu.label') }}"
                type="button"
                class="fi-user-menu-trigger vs-user-menu-trigger tb-btn"
            >
                <x-filament-panels::avatar.user :user="$user" loading="lazy" />
            </button>
        @endif
    </x-slot>

    <div class="vs-user-menu-panel dropdown-panel user-panel">
        <div class="vs-user-menu-header user-panel-header">
            <x-filament-panels::avatar.user :user="$user" loading="lazy" class="vs-user-menu-header-avatar" />

            <div class="vs-user-menu-header-copy">
                <div class="vs-user-menu-header-name user-panel-name">
                    {{ $userName }}
                </div>

                @if (filled($userEmail))
                    <div class="vs-user-menu-header-email user-panel-email">
                        {{ $userEmail }}
                    </div>
                @endif
            </div>
        </div>

        @if ($itemsBeforeThemeSwitcher->isNotEmpty())
            <x-filament::dropdown.list class="vs-user-menu-list">
                @foreach ($itemsBeforeThemeSwitcher as $key => $item)
                    @if ($key === 'profile')
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_BEFORE) }}
                    @endif

                    {{ $item }}

                    @if ($key === 'profile')
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_AFTER) }}
                    @endif
                @endforeach
            </x-filament::dropdown.list>
        @endif

        @if ($itemsAfterThemeSwitcher->isNotEmpty())
            <div class="vs-user-menu-divider"></div>

            <x-filament::dropdown.list class="vs-user-menu-list">
                @foreach ($itemsAfterThemeSwitcher as $key => $item)
                    @if ($key === 'profile')
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_BEFORE) }}
                    @endif

                    {{ $item }}

                    @if ($key === 'profile')
                        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_PROFILE_AFTER) }}
                    @endif
                @endforeach
            </x-filament::dropdown.list>
        @endif
    </div>
</x-filament::dropdown>

{{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::USER_MENU_AFTER) }}
