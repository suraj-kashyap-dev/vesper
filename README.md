# Vesper

Vesper is a Composer-installable Filament 5 theme plugin with premium-style runtime customization. It supports preset-driven palettes, semantic Filament colors, runtime CSS token overrides, configurable layout behavior, and package-owned Blade overrides for the shell.

## Install

```bash
composer require suraj-kashyap-dev/vesper
```

Register the plugin on your panel provider:

```php
use Kashyap\Vesper\VesperPlugin;

$panel->plugins([
    VesperPlugin::make(),
]);
```

## What You Can Customize

- Preset theme palette: `cassandra`, `emerald`, `sunset`, `amethyst`
- Semantic Filament colors: `primary`, `success`, `warning`, `danger`, `info`, `gray`
- Runtime CSS tokens for light and dark surfaces, accent colors, gradients, shadows, radii, and typography variables
- Shell sizing tokens for dropdown widths, search widths, control radii, avatars, and panel chrome
- Layout behavior: default theme mode, sidebar widths, collapsibility, search shortcuts, debounce, and content widths
- Font loading: use the default Google font stylesheet, swap it for your own, or set it to `null`
- Header actions: help URL and theme-toggle visibility
- Branding copy: name, eyebrow, mark
- Sidebar fallback labels and role label

## Example Configuration

```php
use Filament\Enums\ThemeMode;
use Filament\Support\Enums\Width;

return [
    'preset' => 'emerald',

    'layout' => [
        'default_theme_mode' => ThemeMode::System,
        'sidebar_width' => '17rem',
        'collapsed_sidebar_width' => '4.75rem',
        'global_search_key_bindings' => ['mod+k', 'ctrl+/'],
        'global_search_debounce' => '350ms',
        'max_content_width' => Width::SevenExtraLarge,
    ],

    'fonts' => [
        'body' => "'Instrument Sans', sans-serif",
        'mono' => "'JetBrains Mono', monospace",
        'heading' => "'Sora', sans-serif",
        'stylesheet' => null,
    ],

    'header' => [
        'help_url' => 'https://example.com/docs',
        'show_theme_toggle' => true,
    ],

    'colors' => [
        'primary' => 'teal',
        'info' => 'sky',
    ],

    'tokens' => [
        'shared' => [
            'vs-control-radius' => '999px',
            'vs-user-menu-width' => '18rem',
            'vs-search-width-focus' => '24rem',
            'vs-brand-gradient-end' => '#123456',
            'vs-avatar-gradient-end' => '#22d3ee',
        ],
        'light' => [
            'vs-surface-2' => '#eefbf5',
        ],
        'dark' => [
            'vs-surface-3' => '#173328',
        ],
    ],
];
```

The published config defaults `fonts.stylesheet` to the package's Google Fonts URL. Set it to `null` if you want to self-host fonts or avoid external requests entirely.

## Useful Token Names

- Shared: `vs-control-radius`, `vs-kbd-radius`, `vs-radius-pill`, `vs-search-width`, `vs-search-width-focus`, `vs-dropdown-width`, `vs-user-menu-width`, `vs-notifications-width`, `vs-user-avatar-size`, `vs-user-avatar-lg-size`
- Shared: `vs-accent`, `vs-accent-strong`, `vs-accent-soft`, `vs-accent-glow`, `vs-success`, `vs-warning`, `vs-danger`, `vs-brand-gradient-start`, `vs-brand-gradient-end`, `vs-avatar-gradient-start`, `vs-avatar-gradient-end`
- Light: `vs-bg`, `vs-surface-1`, `vs-surface-2`, `vs-surface-3`, `vs-surface-4`, `vs-border`, `vs-border-strong`, `vs-shadow`, `vs-shadow-soft`, `vs-panel-highlight-border`
- Dark: `vs-bg`, `vs-surface-1`, `vs-surface-2`, `vs-surface-3`, `vs-surface-4`, `vs-border`, `vs-border-strong`, `vs-shadow`, `vs-shadow-soft`, `vs-panel-highlight-border`

## Presets

- `cassandra`: cool blue default
- `emerald`: green/teal shell
- `sunset`: warm orange/coral shell
- `amethyst`: violet/pink shell

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
