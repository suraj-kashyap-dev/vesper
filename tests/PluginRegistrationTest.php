<?php

use Filament\Enums\ThemeMode;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Support\ThemeConfiguration;
use Kashyap\Vesper\VesperPlugin;

it('registers the configured theme and colors on a panel', function (): void {
    config()->set('vesper.theme_id', 'custom-vesper');
    config()->set('vesper.layout.max_content_width', Width::SevenExtraLarge);
    config()->set('vesper.colors', [
        'primary' => 'amber',
        'gray' => 'zinc',
    ]);

    $panel = Panel::make()->id('admin');

    VesperPlugin::make()->register($panel);

    expect($panel->getTheme()->getId())->toBe('custom-vesper');
    expect($panel->getMaxContentWidth())->toBe(Width::SevenExtraLarge);
    expect($panel->getColors()['primary'])->toBe(Color::Amber);
    expect($panel->getColors()['gray'])->toBe(Color::Zinc);
});

it('applies layout options from configuration', function (): void {
    config()->set('vesper.layout', [
        'default_theme_mode' => ThemeMode::System,
        'top_navigation' => false,
        'sidebar_width' => '18rem',
        'collapsed_sidebar_width' => '5rem',
        'sidebar_collapsible_on_desktop' => false,
        'sidebar_fully_collapsible_on_desktop' => true,
        'collapsible_navigation_groups' => true,
        'global_search_key_bindings' => ['ctrl+/', 'mod+k'],
        'show_global_search_key_binding_suffix' => false,
        'global_search_debounce' => '750ms',
        'max_content_width' => Width::FiveExtraLarge,
        'simple_page_max_content_width' => Width::Small,
    ]);

    $panel = Panel::make()->id('admin');

    VesperPlugin::make()->register($panel);

    expect($panel->getDefaultThemeMode())->toBe(ThemeMode::System);
    expect($panel->hasTopNavigation())->toBeFalse();
    expect($panel->getSidebarWidth())->toBe('18rem');
    expect($panel->getCollapsedSidebarWidth())->toBe('5rem');
    expect($panel->isSidebarCollapsibleOnDesktop())->toBeFalse();
    expect($panel->isSidebarFullyCollapsibleOnDesktop())->toBeTrue();
    expect($panel->hasCollapsibleNavigationGroups())->toBeTrue();
    expect($panel->getGlobalSearchKeyBindings())->toBe(['ctrl+/', 'mod+k']);
    expect($panel->getGlobalSearchFieldSuffix())->toBeNull();
    expect($panel->getGlobalSearchDebounce())->toBe('750ms');
    expect($panel->getMaxContentWidth())->toBe(Width::FiveExtraLarge);
    expect($panel->getSimplePageMaxContentWidth())->toBe(Width::Small);
});

it('can enable top navigation from configuration', function (): void {
    config()->set('vesper.layout.top_navigation', true);

    $panel = Panel::make()->id('admin');

    VesperPlugin::make()->register($panel);

    expect($panel->hasTopNavigation())->toBeTrue();
});

it('registers the static theme customization hook only', function (): void {
    $panel = Panel::make()->id('admin');

    VesperPlugin::make()->register($panel);

    $renderHooks = new ReflectionProperty(Panel::class, 'renderHooks');
    $renderHooks->setAccessible(true);

    expect($renderHooks->getValue($panel))
        ->toHaveKey(PanelsRenderHook::HEAD_END)
        ->not->toHaveKey(PanelsRenderHook::BODY_END);
});

it('falls back to gray when a configured color alias is unknown', function (): void {
    config()->set('vesper.colors', [
        'primary' => 'not-a-filament-color',
    ]);

    $panel = Panel::make()->id('admin');

    VesperPlugin::make()->register($panel);

    expect($panel->getColors()['primary'])->toBe(Color::Gray);
});

it('merges preset colors and token overrides', function (): void {
    config()->set('vesper.preset', ThemePreset::Emerald->value);
    config()->set('vesper.colors.info', 'sky');
    config()->set('vesper.tokens.shared.vs-brand-gradient-end', '#123456');

    $theme = ThemeConfiguration::resolve();
    $cssVariables = ThemeConfiguration::resolveCssVariableSections();

    expect($theme['colors']['primary'])->toBe('emerald');
    expect($theme['colors']['info'])->toBe('sky');
    expect($cssVariables['preset'])->toBe(ThemePreset::Emerald->value);
    expect($cssVariables['fontStylesheet'])->toContain('fonts.googleapis.com');
    expect($cssVariables['root']['--vs-brand-gradient-end'])->toBe('#123456');
    expect($cssVariables['root']['--vs-user-menu-width'])->toBe('220px');
    expect($cssVariables['dark']['--vs-accent-2'])->toBe('#6ee7b7');
    expect($cssVariables['dark']['--vs-panel-highlight-border'])->toBe('rgba(255, 255, 255, 0.04)');
    expect($cssVariables['dark']['--vs-bg'])->toBe('#0a0a0a');
});

it('falls back to the built-in enum default when a preset is missing', function (): void {
    config()->set('vesper.preset', 'missing-preset');

    $theme = ThemeConfiguration::resolve();

    expect($theme['preset'])->toBe(ThemePreset::fallback()->value);
    expect($theme['colors']['primary'])->toBe('blue');
});

it('supports custom preset names beyond the built-in enum set', function (): void {
    config()->set('vesper.preset', 'custom-brand');
    config()->set('vesper.presets.custom-brand', [
        'colors' => [
            'primary' => 'fuchsia',
        ],
        'tokens' => [
            'shared' => [
                'vs-brand-gradient-end' => '#111827',
            ],
            'dark' => [
                'vs-accent-2' => '#f0abfc',
            ],
        ],
    ]);

    $theme = ThemeConfiguration::resolve();
    $cssVariables = ThemeConfiguration::resolveCssVariableSections();

    expect($theme['preset'])->toBe('custom-brand');
    expect($theme['colors']['primary'])->toBe('fuchsia');
    expect($cssVariables['root']['--vs-brand-gradient-end'])->toBe('#111827');
    expect($cssVariables['dark']['--vs-accent-2'])->toBe('#f0abfc');
});
