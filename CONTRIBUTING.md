# Contributing to Vesper

Thanks for taking the time to contribute! Vesper is a Composer-installable
Filament theme plugin, and we welcome bug reports, feature requests, and pull
requests.

## Code of Conduct

This project and everyone participating in it is governed by our
[Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to
uphold it. Please report unacceptable behavior to the maintainers.

## Ways to Contribute

- **Report bugs** — open an issue using the bug report template.
- **Request features** — open an issue using the feature request template.
- **Improve docs** — fixes to the README or files under `docs/` are very welcome.
- **Submit code** — open a pull request following the guidelines below.

## Development Setup

Vesper is built to live inside a Laravel app or monorepo that has Filament
installed, because the CSS build imports Filament core CSS from the parent app.

```bash
# Install PHP dependencies
composer install

# Install the Tailwind CLI tooling
npm install

# Build the compiled theme asset
npm run build:css
```

See [AGENTS.md](AGENTS.md) for the full architecture overview and the
environment notes about the parent-app CSS import.

## Before You Open a Pull Request

Please make sure the following pass locally:

```bash
# Run the test suite
composer test

# Static analysis
composer analyse

# Code style (PHP)
composer format
```

Guidelines:

- Treat `config/vesper.php` as the public API. If you add or rename config keys,
  update the tests and README in the same change.
- Prefer config-driven tokens, presets, and resolver updates over hardcoded
  per-preset CSS branches.
- Keep Blade overrides narrow — favor CSS or runtime variables over deeper markup
  divergence from upstream Filament.
- Rebuild `dist/vesper.css` after CSS or Blade changes that affect generated
  utilities.
- Add or update tests for the behavior you change.
- Update [CHANGELOG.md](CHANGELOG.md) under an "Unreleased" section.

## Pull Request Process

1. Fork the repository and create your branch from `main`.
2. Make your changes with clear, focused commits.
3. Ensure tests, static analysis, and formatting all pass.
4. Open a pull request describing the change and linking any related issues.
5. A maintainer will review your PR. Please be responsive to feedback.

## Commit Messages

Write clear, descriptive commit messages in the imperative mood
(e.g. "Add sunset preset token overrides"). Reference issues where relevant.

## License

By contributing, you agree that your contributions will be licensed under the
[MIT License](LICENSE) that covers this project.
