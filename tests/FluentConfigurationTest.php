<?php

use Filament\Enums\ThemeMode;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Support\ThemeConfiguration;
use Kashyap\Vesper\Theme\Presets\AbstractPreset;
use Kashyap\Vesper\VesperPlugin;

it('configures the panel entirely through the fluent api without config', function (): void {
    $panel = Panel::make()->id('admin');

    VesperPlugin::make()
        ->themeId('fluent-vesper')
        ->preset(ThemePreset::Emerald)
        ->colors(['primary' => 'amber', 'gray' => 'zinc'])
        ->layout([
            'sidebar_width' => '18rem',
            'top_navigation' => true,
            'max_content_width' => Width::FiveExtraLarge,
        ])
        ->register($panel);

    expect($panel->getTheme()->getId())->toBe('fluent-vesper');
    expect($panel->getColors()['primary'])->toBe(Color::Amber);
    expect($panel->getColors()['gray'])->toBe(Color::Zinc);
    expect($panel->getSidebarWidth())->toBe('18rem');
    expect($panel->hasTopNavigation())->toBeTrue();
    expect($panel->getMaxContentWidth())->toBe(Width::FiveExtraLarge);
});

it('resolves preset palette and token overrides from the fluent api', function (): void {
    $plugin = VesperPlugin::make()
        ->preset(ThemePreset::Emerald)
        ->tokens(['shared' => ['vs-brand-gradient-end' => '#123456']]);

    $theme = $plugin->toThemeArray();
    $cssVariables = ThemeConfiguration::resolveCssVariableSections($theme);

    expect($theme['preset'])->toBe(ThemePreset::Emerald->value);
    expect($cssVariables['root']['--vs-brand-gradient-end'])->toBe('#123456');
    expect($cssVariables['root']['--vs-user-menu-width'])->toBe('220px');
    expect($cssVariables['root']['--vs-surface-1'])->toBe('#fcfdfc');
    expect($cssVariables['dark']['--vs-accent-2'])->toBe('#6ee7b7');
    expect($cssVariables['dark']['--vs-bg'])->toBe('#0a0a0a');
});

it('registers a custom preset and selects it', function (): void {
    $preset = new class extends AbstractPreset
    {
        public function key(): string
        {
            return 'custom-brand';
        }

        public function colors(): array
        {
            return ['primary' => 'fuchsia'];
        }

        protected function paletteTokens(): array
        {
            return ['dark' => ['vs-accent-2' => '#f0abfc']];
        }
    };

    $theme = VesperPlugin::make()
        ->registerPreset($preset)
        ->preset('custom-brand')
        ->toThemeArray();

    $resolved = ThemeConfiguration::resolve($theme);
    $cssVariables = ThemeConfiguration::resolveCssVariableSections($theme);

    expect($resolved['preset'])->toBe('custom-brand');
    expect($resolved['colors']['primary'])->toBe('fuchsia');
    expect($cssVariables['dark']['--vs-accent-2'])->toBe('#f0abfc');
});

it('falls back to the built-in default preset for an unknown selection', function (): void {
    $theme = VesperPlugin::make()->preset('missing-preset')->toThemeArray();

    $resolved = ThemeConfiguration::resolve($theme);

    expect($resolved['preset'])->toBe(ThemePreset::fallback()->value);
    expect($resolved['colors']['primary'])->toBe('blue');
});

it('exposes branding and sidebar values through getters', function (): void {
    $plugin = VesperPlugin::make()
        ->branding(name: 'Acme', eyebrow: 'Acme Admin', mark: 'AC')
        ->sidebar(overviewLabel: 'Home', userRole: 'Owner');

    expect($plugin->getBranding('name'))->toBe('Acme');
    expect($plugin->getBranding('eyebrow'))->toBe('Acme Admin');
    expect($plugin->getBranding('mark'))->toBe('AC');
    expect($plugin->getSidebar('overview_label'))->toBe('Home');
    expect($plugin->getSidebar('user_role'))->toBe('Owner');
});

it('toggles the header help url on and off', function (): void {
    $enabled = VesperPlugin::make()->header(helpUrl: 'https://example.com/docs');
    expect($enabled->getHelpUrl())->toBe('https://example.com/docs');

    $disabled = VesperPlugin::make()
        ->header(helpUrl: 'https://example.com/docs', showHelpUrl: false);
    expect($disabled->getHelpUrl())->toBeNull();

    $noUrl = VesperPlugin::make()->header(showHelpUrl: true);
    expect($noUrl->getHelpUrl())->toBeNull();
});

it('honors the default theme mode through the fluent layout api', function (): void {
    $panel = Panel::make()->id('admin');

    VesperPlugin::make()
        ->layout(['default_theme_mode' => ThemeMode::Dark])
        ->register($panel);

    expect($panel->getDefaultThemeMode())->toBe(ThemeMode::Dark);
});
