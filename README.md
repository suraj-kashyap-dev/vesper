# Vesper

[![Latest Version on Packagist](https://img.shields.io/packagist/v/suraj-kashyap-dev/vesper.svg?style=flat-square)](https://packagist.org/packages/suraj-kashyap-dev/vesper)
[![Total Downloads](https://img.shields.io/packagist/dt/suraj-kashyap-dev/vesper.svg?style=flat-square)](https://packagist.org/packages/suraj-kashyap-dev/vesper)
[![License](https://img.shields.io/packagist/l/suraj-kashyap-dev/vesper.svg?style=flat-square)](https://packagist.org/packages/suraj-kashyap-dev/vesper)
[![PHP Version](https://img.shields.io/packagist/php-v/suraj-kashyap-dev/vesper.svg?style=flat-square)](https://packagist.org/packages/suraj-kashyap-dev/vesper)

Vesper is a Composer-installable Filament 5 theme plugin with premium-style runtime customization. It supports preset-driven palettes, semantic Filament colors, runtime CSS token overrides, configurable layout behavior, and package-owned Blade overrides for the shell.

The package is published on Packagist: **[suraj-kashyap-dev/vesper](https://packagist.org/packages/suraj-kashyap-dev/vesper)**.

## Install

```bash
composer require suraj-kashyap-dev/vesper
```

Register the plugin on your panel provider — every preset and design token ships inside the package, so there is no config to publish:

```php
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\VesperPlugin;

$panel->plugin(
    VesperPlugin::make()
        ->preset(ThemePreset::Sunset),
);
```

## What You Can Customize

- Preset theme palette: `emerald`, `sunset`, `amethyst`, `burgundy`, `champagne`, `obsidian`, `platinum`, `sapphire`
- Semantic Filament colors: `primary`, `success`, `warning`, `danger`, `info`, `gray`
- Runtime CSS tokens for light and dark surfaces, accent colors, gradients, shadows, radii, and typography variables
- Shell sizing tokens for dropdown widths, search widths, control radii, avatars, and panel chrome
- Layout behavior: default theme mode, sidebar widths, collapsibility, search shortcuts, debounce, and content widths
- Font loading: use the default Google font stylesheet, swap it for your own, or set it to `null`
- Header actions: help URL (with an enable/disable toggle) and theme-toggle visibility
- Branding copy: name, eyebrow, mark
- Sidebar fallback labels and role label

## Configuring The Plugin

Configure everything fluently on the plugin instance:

```php
use Filament\Enums\ThemeMode;
use Filament\Support\Enums\Width;
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\VesperPlugin;

$panel->plugin(
    VesperPlugin::make()
        ->preset(ThemePreset::Emerald)
        ->branding(name: 'Acme', eyebrow: 'Acme Admin', mark: 'AC')
        ->header(helpUrl: 'https://example.com/docs', showHelpUrl: true, showThemeToggle: true)
        ->sidebar(overviewLabel: 'Overview', userRole: 'Owner')
        ->fonts(
            body: "'Instrument Sans', sans-serif",
            mono: "'JetBrains Mono', monospace",
            heading: "'Sora', sans-serif",
        )
        ->colors([
            'primary' => 'teal',
            'info' => 'sky',
        ])
        ->tokens([
            'shared' => [
                'vs-control-radius' => '999px',
                'vs-user-menu-width' => '18rem',
                'vs-brand-gradient-end' => '#123456',
            ],
            'light' => ['vs-surface-2' => '#eefbf5'],
            'dark' => ['vs-surface-3' => '#173328'],
        ])
        ->layout([
            'default_theme_mode' => ThemeMode::System,
            'sidebar_width' => '17rem',
            'global_search_key_bindings' => ['mod+k', 'ctrl+/'],
            'max_content_width' => Width::SevenExtraLarge,
        ]),
);
```

To hide the header help link entirely, pass `->header(showHelpUrl: false)` (or simply omit the `helpUrl`).

### Registering A Custom Preset

Presets are first-class classes. Implement `Kashyap\Vesper\Theme\Contracts\Preset` — or extend `AbstractPreset` to inherit the shared foundation tokens — then register it:

```php
use Kashyap\Vesper\Theme\Presets\AbstractPreset;
use Kashyap\Vesper\VesperPlugin;

class MidnightPreset extends AbstractPreset
{
    public function key(): string
    {
        return 'midnight';
    }

    public function colors(): array
    {
        return ['primary' => 'indigo', 'gray' => 'slate'];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => ['vs-accent' => '#6366f1', 'vs-accent-strong' => '#4f46e5'],
            'dark' => ['vs-accent-2' => '#a5b4fc'],
        ];
    }
}

$panel->plugin(
    VesperPlugin::make()
        ->registerPreset(new MidnightPreset)
        ->preset('midnight'),
);
```

### Optional config fallback

Publishing the config file remains optional and purely additive — fluent plugin calls win over it:

```bash
php artisan vendor:publish --tag="vesper-config"
```

## Useful Token Names

- Shared: `vs-control-radius`, `vs-kbd-radius`, `vs-radius-pill`, `vs-search-width`, `vs-search-width-focus`, `vs-dropdown-width`, `vs-user-menu-width`, `vs-notifications-width`, `vs-user-avatar-size`, `vs-user-avatar-lg-size`
- Shared: `vs-accent`, `vs-accent-strong`, `vs-accent-soft`, `vs-accent-glow`, `vs-success`, `vs-warning`, `vs-danger`, `vs-brand-gradient-start`, `vs-brand-gradient-end`, `vs-avatar-gradient-start`, `vs-avatar-gradient-end`
- Light: `vs-bg`, `vs-surface-1`, `vs-surface-2`, `vs-surface-3`, `vs-surface-4`, `vs-border`, `vs-border-strong`, `vs-shadow`, `vs-shadow-soft`, `vs-panel-highlight-border`
- Dark: `vs-bg`, `vs-surface-1`, `vs-surface-2`, `vs-surface-3`, `vs-surface-4`, `vs-border`, `vs-border-strong`, `vs-shadow`, `vs-shadow-soft`, `vs-panel-highlight-border`

## Presets

Selected with `->preset(ThemePreset::Sapphire)` (or the string key):

- `sapphire`: cool blue default
- `emerald`: green/teal shell
- `sunset`: warm orange/coral shell
- `amethyst`: violet/pink shell
- `burgundy`: deep wine/rose shell
- `champagne`: warm gold shell
- `obsidian`: neutral zinc shell
- `platinum`: cool slate shell

## Build

From the package directory:

```bash
npm install
npm run build
```

That rebuilds `dist/vesper.css` and republishes the package asset for local app testing.

## Docs

- `docs/README.md` contains the package map.
- `docs/config-reference.md` documents the config surface in detail.
- `docs/files/*.md` contains file-level runtime docs.

## Verification

For the local app in this repository:

```bash
php artisan test tests/Filament/Pages/TopbarOverrideTest.php
php artisan test tests/Filament/Pages/ThemeCustomizationTest.php
```
