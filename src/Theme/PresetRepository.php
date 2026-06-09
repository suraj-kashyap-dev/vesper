<?php

namespace Kashyap\Vesper\Theme;

use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Theme\Contracts\Preset;
use Kashyap\Vesper\Theme\Presets\AmethystPreset;
use Kashyap\Vesper\Theme\Presets\BurgundyPreset;
use Kashyap\Vesper\Theme\Presets\ChampagnePreset;
use Kashyap\Vesper\Theme\Presets\EmeraldPreset;
use Kashyap\Vesper\Theme\Presets\ObsidianPreset;
use Kashyap\Vesper\Theme\Presets\PlatinumPreset;
use Kashyap\Vesper\Theme\Presets\SapphirePreset;
use Kashyap\Vesper\Theme\Presets\SunsetPreset;

class PresetRepository
{
    /**
     * @var array<string, Preset>
     */
    private array $presets = [];

    public function __construct()
    {
        foreach (static::builtIn() as $preset) {
            $this->register($preset);
        }
    }

    /**
     * The built-in presets that ship with Vesper.
     *
     * @return list<Preset>
     */
    public static function builtIn(): array
    {
        return [
            new EmeraldPreset,
            new SunsetPreset,
            new AmethystPreset,
            new BurgundyPreset,
            new ChampagnePreset,
            new ObsidianPreset,
            new PlatinumPreset,
            new SapphirePreset,
        ];
    }

    public function register(Preset $preset): static
    {
        $this->presets[$preset->key()] = $preset;

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->presets);
    }

    public function get(string $key): ?Preset
    {
        return $this->presets[$key] ?? null;
    }

    /**
     * @return array<string, Preset>
     */
    public function all(): array
    {
        return $this->presets;
    }

    public function fallback(): Preset
    {
        return $this->get(ThemePreset::fallback()->value)
            ?? new SapphirePreset;
    }

    /**
     * Flatten every registered preset into the `config('vesper.presets')` array shape.
     *
     * @return array<string, array{colors: array<string, string>, tokens: array<string, mixed>}>
     */
    public function toArray(): array
    {
        $resolved = [];

        foreach ($this->presets as $key => $preset) {
            $resolved[$key] = [
                'colors' => $preset->colors(),
                'tokens' => $preset->tokens(),
            ];
        }

        return $resolved;
    }
}
