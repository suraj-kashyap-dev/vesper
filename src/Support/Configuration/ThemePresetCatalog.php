<?php

namespace Kashyap\Vesper\Support\Configuration;

use BackedEnum;
use Kashyap\Vesper\Enums\ThemeConfigSection;
use Kashyap\Vesper\Enums\ThemePreset;
use Illuminate\Support\Arr;

class ThemePresetCatalog
{
    public function __construct(
        private readonly array $config,
    ) {}

    public function all(): array
    {
        return (array) Arr::get($this->config, ThemeConfigSection::Presets->value, []);
    }

    public function fallbackName(): string
    {
        return ThemePreset::fallback()->value;
    }

    public function selectedName(): string
    {
        $requestedPreset = Arr::get($this->config, 'preset', $this->fallbackName());

        if ($requestedPreset instanceof BackedEnum) {
            $requestedPreset = $requestedPreset->value;
        }

        return is_string($requestedPreset) && array_key_exists($requestedPreset, $this->all())
            ? $requestedPreset
            : $this->fallbackName();
    }

    public function definition(string $name): array
    {
        return (array) Arr::get($this->all(), $name, []);
    }

    public function fallbackDefinition(): array
    {
        return $this->definition($this->fallbackName());
    }

    public function selectedDefinition(): array
    {
        return $this->definition($this->selectedName());
    }
}
