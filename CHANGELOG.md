# Changelog

All notable changes to `suraj-kashyap-dev/vesper` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

[1.0.0]: https://github.com/suraj-kashyap-dev/vesper/releases/tag/v1.0.0
