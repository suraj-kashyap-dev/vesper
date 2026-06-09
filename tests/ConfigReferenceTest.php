<?php

use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Enums\ThemeTokenSection;
use Kashyap\Vesper\Theme\PresetRepository;
use Kashyap\Vesper\Theme\Presets\AbstractPreset;
use Kashyap\Vesper\Theme\StructuralTokens;

it('keeps the published config slim and free of bundled theme data', function (): void {
    $contents = file_get_contents(dirname(__DIR__).'/config/vesper.php');

    expect($contents)->not->toContain('require');

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
    ]);

    expect($config)->not->toHaveKey('presets');
    expect($config['colors'])->toBe([]);
    expect($config['tokens'])->toBe([]);

    expect(array_keys($config['header']))->toBe([
        'help_url',
        'show_help_url',
        'show_theme_toggle',
    ]);
});

it('ships every built-in preset as an extensible src class', function (): void {
    $repository = new PresetRepository;

    expect(array_keys($repository->all()))->toBe(ThemePreset::values());
    expect($repository->fallback()->key())->toBe(ThemePreset::fallback()->value);

    foreach ($repository->all() as $key => $preset) {
        expect($preset->key())->toBe($key);
        expect($preset->colors())->not->toBeEmpty();

        $tokens = $preset->tokens();

        expect(array_keys($tokens))->toBe([
            ThemeTokenSection::Shared->value,
            ThemeTokenSection::Light->value,
            ThemeTokenSection::Dark->value,
        ]);
        expect($tokens['shared'])->not->toBeEmpty();
        expect($tokens['shared'])->toHaveKey('vs-accent');
        expect($tokens['dark'])->toHaveKey('vs-bg');
    }
});

it('exposes preset-independent structural tokens', function (): void {
    $tokens = StructuralTokens::all();

    expect(array_keys($tokens))->toBe([
        ThemeTokenSection::Shared->value,
        ThemeTokenSection::Light->value,
        ThemeTokenSection::Dark->value,
    ]);

    expect($tokens['shared'])->toHaveKeys([
        'vs-control-radius',
        'vs-search-width',
        'vs-user-menu-width',
        'vs-user-avatar-lg-size',
    ]);

    expect($tokens['light'])->toBe(['vs-panel-highlight-border' => 'rgba(15, 23, 42, 0.05)']);
    expect($tokens['dark'])->toBe(['vs-panel-highlight-border' => 'rgba(255, 255, 255, 0.04)']);
});

it('lets a custom preset be registered alongside the built-ins', function (): void {
    $repository = new PresetRepository;

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
            return ['shared' => ['vs-accent' => '#d946ef']];
        }
    };

    $repository->register($preset);

    expect($repository->has('custom-brand'))->toBeTrue();
    expect($repository->get('custom-brand')->colors()['primary'])->toBe('fuchsia');
    expect($repository->get('custom-brand')->tokens()['shared']['vs-accent'])->toBe('#d946ef');
});
