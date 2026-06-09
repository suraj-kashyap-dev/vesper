# Changelog

All notable changes to `suraj-kashyap-dev/vesper` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-06-09

Theming moves from publishable config to extensible `src` classes, configured fluently on the plugin. The bulky preset and token data no longer needs to be published.

### Added

- Fluent configuration API on `VesperPlugin`: `preset()`, `registerPreset()`, `branding()`, `header()`, `sidebar()`, `fonts()`, `colors()`, `tokens()`, `layout()`, `themeId()`, and `themeAsset()`.
- `Kashyap\Vesper\Theme\Contracts\Preset` contract and `AbstractPreset` base class — every built-in preset is now a class, and custom presets can be registered via `registerPreset()`.
- `PresetRepository`, `StructuralTokens`, and `ThemeDefaults` carrying the design-system data inside the package.
- `VesperPlugin::current()` for retrieving the active panel's plugin instance from views.
- Header help URL enable/disable toggle (`header(showHelpUrl: ...)` / `show_help_url` config key).

### Changed

- Presets and tokens are no longer shipped as publishable config; the published `config/vesper.php` is now slim and entirely optional, acting as a fallback beneath fluent plugin calls.
- Blade overrides and `TopbarNavigation` read branding/header/sidebar values from the active plugin instead of `config('vesper.*')`.

### Removed

- `config/vesper/tokens.php` and `config/vesper/presets/*.php` (relocated into `src/Theme`).

## [1.0.0] - 2026-06-07

Initial release of Vesper — a Composer-installable Filament theme plugin with premium-style runtime customization.

### Added

- `VesperPlugin` for registering the theme, semantic colors, and layout options on a Filament panel.
- `VesperServiceProvider` with package auto-discovery, config, views, and asset publishing.
- Preset-driven palettes: `cassandra`, `emerald`, `sunset`, `amethyst` (and support for custom preset names).
- Semantic Filament color mapping for `primary`, `success`, `warning`, `danger`, `info`, and `gray`, with a safe fallback to `gray` for unknown aliases.
- Runtime CSS token overrides for light/dark surfaces, accent colors, gradients, shadows, radii, and typography variables (`vs-*` tokens).
- Configurable layout behavior: default theme mode, sidebar widths, collapsibility, global search key bindings and debounce, and max content width.
- Configurable fonts: default Google Fonts stylesheet, custom stylesheet, or self-hosted (`null`).
- Optional top navigation, configurable header help URL, and theme-toggle visibility.
- Branding configuration: name, eyebrow, and mark.
- Package-owned Blade overrides for the Filament shell (panels, notifications, modal, and simple header for auth pages).
- Realtime database notifications toast handling in the notifications override.
- Published `config/vesper.php` with a documented configuration surface.

### Requirements

- `php` `^8.3`
- `filament/filament` `^4.0 || ^5.0`
- `illuminate/contracts` `^12.0 || ^13.0`
- `spatie/laravel-package-tools` `^1.92`

[2.0.0]: https://github.com/suraj-kashyap-dev/vesper/releases/tag/v2.0.0
[1.0.0]: https://github.com/suraj-kashyap-dev/vesper/releases/tag/v1.0.0
