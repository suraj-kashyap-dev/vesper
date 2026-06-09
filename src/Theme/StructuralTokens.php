<?php

namespace Kashyap\Vesper\Theme;

class StructuralTokens
{
    /**
     * Preset-independent shell tokens layered on top of every preset.
     *
     * @return array{shared: array<string, string>, light: array<string, string>, dark: array<string, string>}
     */
    public static function all(): array
    {
        return [
            'shared' => [
                'vs-on-accent' => '#ffffff',
                'vs-floating-shadow' => '0 2px 8px rgba(0, 0, 0, 0.4)',
                'vs-radius-pill' => '999px',
                'vs-active-indicator-radius' => '0 3px 3px 0',
                'vs-sidebar-item-radius' => '8px',
                'vs-control-radius' => '8px',
                'vs-kbd-radius' => '4px',
                'vs-breadcrumb-icon-radius' => '5px',
                'vs-theme-option-radius' => '6px',
                'vs-control-size' => '34px',
                'vs-theme-toggle-size' => '28px',
                'vs-search-width' => '240px',
                'vs-search-width-focus' => '300px',
                'vs-search-width-mobile' => '160px',
                'vs-search-width-mobile-focus' => '200px',
                'vs-dropdown-width' => '323px',
                'vs-user-menu-width' => '220px',
                'vs-notifications-width' => '320px',
                'vs-user-avatar-size' => '32px',
                'vs-user-avatar-lg-size' => '36px',
            ],
            'light' => [
                'vs-panel-highlight-border' => 'rgba(15, 23, 42, 0.05)',
            ],
            'dark' => [
                'vs-panel-highlight-border' => 'rgba(255, 255, 255, 0.04)',
            ],
        ];
    }
}
