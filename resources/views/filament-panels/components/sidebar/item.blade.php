@props([
    'active' => false,
    'activeChildItems' => false,
    'activeIcon' => null,
    'badge' => null,
    'badgeColor' => null,
    'badgeTooltip' => null,
    'childItems' => [],
    'first' => false,
    'icon' => null,
    'last' => false,
    'shouldOpenUrlInNewTab' => false,
    'url',
])

@php
    $hasChildItems = filled($childItems);
    $badgeTone = match ($badgeColor) {
        'success' => 'green',
        'warning' => 'amber',
        default => 'blue',
    };
@endphp

<li
    x-data="{ submenuOpen: @js($active || $activeChildItems) }"
    {{
        $attributes->class([
            'fi-sidebar-item',
            'fi-active' => $active,
            'fi-sidebar-item-has-active-child-items' => $activeChildItems,
            'fi-sidebar-item-has-url' => filled($url),
        ])
    }}
>
    @if ($hasChildItems)
        <button
            type="button"
            x-data="{ tooltip: false }"
            x-effect="
                tooltip = $store.sidebar.isOpen
                    ? false
                    : {
                          content: @js($slot->toHtml()),
                          delay: [90, 0],
                          maxWidth: 280,
                          offset: [0, 14],
                          placement: document.dir === 'rtl' ? 'left' : 'right',
                          theme: $store.theme,
                      }
            "
            x-tooltip.html="tooltip"
            x-on:click="submenuOpen = ! submenuOpen"
            class="fi-sidebar-item-btn sb-item {{ ($active || $activeChildItems) ? 'active' : '' }}"
        >
            @if (filled($icon))
                <span class="sb-item-icon" aria-hidden="true">
                    {{
                        \Filament\Support\generate_icon_html(
                            ($active && $activeIcon) ? $activeIcon : $icon,
                            attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['sb-item-icon-svg']),
                            size: \Filament\Support\Enums\IconSize::Large,
                        )
                    }}
                </span>
            @endif

            <span class="sb-item-label">
                {{ $slot }}
            </span>

            @if (filled($badge))
                <span class="sb-badge {{ $badgeTone }}" @if (filled($badgeTooltip)) title="{{ $badgeTooltip }}" @endif>
                    {{ $badge }}
                </span>
            @endif

            <span class="sb-chevron" x-bind:class="{ 'open': submenuOpen }" aria-hidden="true">
                &#8250;
            </span>
        </button>

        <ul
            x-show="submenuOpen"
            x-collapse.duration.300ms
            class="sb-sub"
        >
            @foreach ($childItems as $childItem)
                @php
                    $isChildItemChildItemsActive = $childItem->isChildItemsActive();
                    $isChildActive = (! $isChildItemChildItemsActive) && $childItem->isActive();
                @endphp

                <li>
                    <a
                        {{ \Filament\Support\generate_href_html($childItem->getUrl(), $childItem->shouldOpenUrlInNewTab()) }}
                        x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
                        class="sb-sub-item {{ $isChildActive ? 'active' : '' }}"
                    >
                        <span class="sb-sub-dot"></span>
                        <span>{{ $childItem->getLabel() }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <a
            {{ \Filament\Support\generate_href_html($url, $shouldOpenUrlInNewTab) }}
            x-data="{ tooltip: false }"
            x-effect="
                tooltip = $store.sidebar.isOpen
                    ? false
                    : {
                          content: @js($slot->toHtml()),
                          delay: [90, 0],
                          maxWidth: 280,
                          offset: [0, 14],
                          placement: document.dir === 'rtl' ? 'left' : 'right',
                          theme: $store.theme,
                      }
            "
            x-tooltip.html="tooltip"
            x-on:click="window.matchMedia(`(max-width: 1024px)`).matches && $store.sidebar.close()"
            class="fi-sidebar-item-btn sb-item {{ $active ? 'active' : '' }}"
        >
            @if (filled($icon))
                <span class="sb-item-icon" aria-hidden="true">
                    {{
                        \Filament\Support\generate_icon_html(
                            ($active && $activeIcon) ? $activeIcon : $icon,
                            attributes: (new \Illuminate\View\ComponentAttributeBag)->class(['sb-item-icon-svg']),
                            size: \Filament\Support\Enums\IconSize::Large,
                        )
                    }}
                </span>
            @endif

            <span class="sb-item-label">
                {{ $slot }}
            </span>

            @if (filled($badge))
                <span class="sb-badge {{ $badgeTone }}" @if (filled($badgeTooltip)) title="{{ $badgeTooltip }}" @endif>
                    {{ $badge }}
                </span>
            @endif
        </a>
    @endif
</li>
