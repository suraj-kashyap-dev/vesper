<?php

use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Enums\ThemeTokenSection;

it('only exposes configuration keys that are read at runtime', function (): void {
    $config = require dirname(__DIR__).'/config/vesper.php';

    expect(array_keys($config))->toBe([
        'theme_id',
        'theme_asset',
        'override_filament_panels_views',
        'preset',
        'layout',
        'fonts',
        'branding',
        'header',
        'sidebar',
        'colors',
        'tokens',
        'presets',
    ]);

    expect(array_keys($config['layout']))->toBe([
        'default_theme_mode',
        'top_navigation',
        'sidebar_width',
        'collapsed_sidebar_width',
        'sidebar_collapsible_on_desktop',
        'sidebar_fully_collapsible_on_desktop',
        'collapsible_navigation_groups',
        'global_search_key_bindings',
        'show_global_search_key_binding_suffix',
        'global_search_debounce',
        'max_content_width',
        'simple_page_max_content_width',
    ]);

    expect(array_keys($config['fonts']))->toBe([
        'body',
        'mono',
        'heading',
        'stylesheet',
    ]);

    expect(array_keys($config['branding']))->toBe([
        'name',
        'eyebrow',
        'mark',
    ]);

    expect(array_keys($config['header']))->toBe([
        'help_url',
        'show_theme_toggle',
    ]);

    expect(array_keys($config['sidebar']))->toBe([
        'overview_label',
        'user_role',
    ]);

    expect(array_keys($config['tokens']))->toBe([
        ThemeTokenSection::Shared->value,
        ThemeTokenSection::Light->value,
        ThemeTokenSection::Dark->value,
    ]);

    expect(array_keys($config['tokens']['shared']))->toBe([
        'vs-on-accent',
        'vs-floating-shadow',
        'vs-radius-pill',
        'vs-active-indicator-radius',
        'vs-sidebar-item-radius',
        'vs-control-radius',
        'vs-kbd-radius',
        'vs-breadcrumb-icon-radius',
        'vs-theme-option-radius',
        'vs-control-size',
        'vs-theme-toggle-size',
        'vs-search-width',
        'vs-search-width-focus',
        'vs-search-width-mobile',
        'vs-search-width-mobile-focus',
        'vs-dropdown-width',
        'vs-user-menu-width',
        'vs-notifications-width',
        'vs-user-avatar-size',
        'vs-user-avatar-lg-size',
    ]);

    expect(array_keys($config['tokens']['light']))->toBe([
        'vs-panel-highlight-border',
    ]);

    expect(array_keys($config['tokens']['dark']))->toBe([
        'vs-panel-highlight-border',
    ]);

    expect($config['fonts']['stylesheet'])->toContain('fonts.googleapis.com');

    expect(array_keys($config['presets']))->toBe(ThemePreset::values());
});
