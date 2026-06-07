<?php

use Filament\Enums\ThemeMode;
use Filament\Support\Enums\Width;
use Kashyap\Vesper\Enums\ThemePreset;

return [
    'theme_id' => 'vesper',
    'theme_asset' => 'vesper.css',
    'override_filament_panels_views' => true,
    'preset' => ThemePreset::Sunset->value, // Emerald, Sunset, Amethyst, Burgundy, Champagne, Obsidian, Platinum, Sapphire
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
        'name' => 'Suraj Kashyap',
        'eyebrow' => 'A theme by Suraj Kashyap',
        'mark' => 'SK',
    ],
    'header' => [
        'help_url' => 'https://filamentphp.com/docs',
        'show_theme_toggle' => true,
    ],
    'sidebar' => [
        'overview_label' => 'Overview',
        'user_role' => 'Administrator',
    ],
    'colors' => [],
    'tokens' => require __DIR__.'/vesper/tokens.php',
    'presets' => [
        ThemePreset::Emerald->value => require __DIR__.'/vesper/presets/emerald.php',
        ThemePreset::Sunset->value => require __DIR__.'/vesper/presets/sunset.php',
        ThemePreset::Amethyst->value => require __DIR__.'/vesper/presets/amethyst.php',
        ThemePreset::Burgundy->value => require __DIR__.'/vesper/presets/burgundy.php',
        ThemePreset::Champagne->value => require __DIR__.'/vesper/presets/champagne.php',
        ThemePreset::Obsidian->value => require __DIR__.'/vesper/presets/obsidian.php',
        ThemePreset::Platinum->value => require __DIR__.'/vesper/presets/platinum.php',
        ThemePreset::Sapphire->value => require __DIR__.'/vesper/presets/sapphire.php',
    ],
];
