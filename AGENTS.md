# Vesper Agent Guide

## Scope

These instructions apply to the entire `suraj-kashyap-dev/vesper` package. Treat it as a reusable Composer package that owns a Filament theme asset, not as an app-local Filament theme.

## Stack

- PHP 8.3
- Laravel package via `spatie/laravel-package-tools`
- Filament `^4.0 || ^5.0`
- Tailwind CSS v4 CLI for the compiled theme asset

## Architecture

- `src/VesperServiceProvider.php`: package bootstrap, config/views registration, theme asset registration, and namespace overrides for package-owned Blade overrides.
- `src/VesperPlugin.php`: panel plugin entrypoint; applies theme id, layout options, semantic colors, and the `HEAD_END` render hook.
- `src/Support/Configuration/*`: resolves config into panel options, CSS variables, theme mode, and preset merging. Keep config interpretation here instead of growing the plugin or service provider.
- `config/vesper.php`: public configuration contract.
- `config/vesper/presets/*.php`: built-in palette and token presets.
- `resources/css/theme.css`: only CSS entrypoint; compiles to `dist/vesper.css`.
- `resources/views/hooks/theme-customization.blade.php`: injects runtime CSS variables and the optional font stylesheet.
- `resources/views/filament-*`: package-owned view overrides for the Filament shell.
- `tests/*.php`: regression coverage for config keys, plugin registration, and view override paths.

## Working Rules

- Keep the package installable as `composer require suraj-kashyap-dev/vesper` with plugin registration through `VesperPlugin::make()`.
- Prefer config-driven tokens, presets, and resolver updates over hardcoded per-preset CSS branches.
- Treat `config/vesper.php` as public API. If you add or rename keys, update tests and README in the same change.
- Keep Blade overrides narrow. If a visual change can live in CSS or runtime variables, prefer that over deeper markup divergence from upstream Filament.
- When adding Tailwind utility usage in new directories, update the `@source` entries in `resources/css/theme.css`.
- Rebuild `dist/vesper.css` after CSS or Blade changes that affect generated utilities.
- Ignore unrelated changes from the parent app or sibling packages; do not revert them unless explicitly asked.

## Build And Verification

From the package directory:

- `npm install`
- `npm run build:css` to rebuild only `dist/vesper.css`
- `npm run build` to rebuild CSS and run `php ../artisan filament:assets`
- `composer test` to run the package test suite when package dependencies are installed

## Environment Notes

- The CSS build imports Filament core CSS from the parent app at `../../../vendor/filament/filament/resources/css/index.css`. Keep the package inside a Laravel app or monorepo with Filament installed there, or adjust the import before building.
- Do not assume a package-local `vendor/` exists; this repo commonly relies on the parent app for Filament assets during frontend builds.
