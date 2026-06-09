<?php

use Filament\Enums\ThemeMode;
use Filament\Support\Enums\Width;
use Kashyap\Vesper\Enums\ThemePreset;

return [
    'theme_id' => 'vesper',
    'theme_asset' => 'vesper.css',
    'override_filament_panels_views' => true,

    'preset' => ThemePreset::Sunset->value,

    'layout' => [
        'default_theme_mode' => ThemeMode::System,
        'top_navigation' => false,
        'sidebar_width' => '252px',
        'collapsed_sidebar_width' => '72px',
        'sidebar_collapsible_on_desktop' => true,
        'sidebar_fully_collapsible_on_desktop' => false,
        'collapsible_navigation_groups' => false,
        'global_search_key_bindings' => ['mod+k'],
        'show_global_search_key_binding_suffix' => true,
        'global_search_debounce' => '500ms',
        'max_content_width' => Width::Full,
        'simple_page_max_content_width' => null,
    ],

    'fonts' => [
        'body' => "'Plus Jakarta Sans', sans-serif",
        'mono' => "'Geist Mono', monospace",
        'heading' => "'Space Grotesk', sans-serif",
        'stylesheet' => 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap',
    ],

    'branding' => [
        'name' => null,
        'eyebrow' => 'Admin Panel',
        'mark' => null,
    ],

    'header' => [
        'help_url' => null,
        'show_help_url' => true,
        'show_theme_toggle' => true,
    ],

    'sidebar' => [
        'overview_label' => 'Overview',
        'user_role' => 'Administrator',
    ],

    'colors' => [],

    'tokens' => [],
];
