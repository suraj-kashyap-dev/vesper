<?php

namespace Kashyap\Vesper\Support\Configuration;

use Illuminate\Support\Arr;
use Kashyap\Vesper\Enums\ThemeConfigSection;
use Kashyap\Vesper\Enums\ThemeTokenSection;

class ThemeSectionMerger
{
    public function merge(array $fallbackPreset, array $selectedPreset, array $config): array
    {
        $resolved = [];

        foreach (ThemeConfigSection::mergeableSections() as $section) {
            $resolved[$section->value] = array_merge(
                $this->arraySection($fallbackPreset, $section->value),
                $this->arraySection($selectedPreset, $section->value),
                $this->arraySection($config, $section->value),
            );
        }

        $resolved[ThemeConfigSection::Layout->value] = $this->normalizeLayout(
            $resolved[ThemeConfigSection::Layout->value],
            $config,
        );

        $resolved[ThemeConfigSection::Tokens->value] = [];

        foreach (ThemeTokenSection::cases() as $tokenSection) {
            $resolved[ThemeConfigSection::Tokens->value][$tokenSection->value] = array_merge(
                $this->arraySection($fallbackPreset, ThemeConfigSection::Tokens->value.'.'.$tokenSection->value),
                $this->arraySection($selectedPreset, ThemeConfigSection::Tokens->value.'.'.$tokenSection->value),
                $this->arraySection($config, ThemeConfigSection::Tokens->value.'.'.$tokenSection->value),
            );
        }

        return $resolved;
    }

    protected function arraySection(array $source, string $path): array
    {
        return (array) Arr::get($source, $path, []);
    }

    protected function normalizeLayout(array $layout, array $config): array
    {
        if (! array_key_exists('max_content_width', $layout) && array_key_exists('max-content-width', $config)) {
            $layout['max_content_width'] = $config['max-content-width'];
        }

        return $layout;
    }
}
