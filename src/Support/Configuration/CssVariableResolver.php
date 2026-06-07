<?php

namespace Kashyap\Vesper\Support\Configuration;

use BackedEnum;
use Kashyap\Vesper\Enums\ThemeConfigSection;
use Kashyap\Vesper\Enums\ThemeFontSlot;
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Enums\ThemeTokenSection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CssVariableResolver
{
    public function resolve(array $theme): array
    {
        return [
            'preset' => Arr::get($theme, 'preset', ThemePreset::fallback()->value),
            'fontStylesheet' => Arr::get($theme, ThemeConfigSection::Fonts->value.'.stylesheet'),
            'root' => array_merge(
                $this->resolveFontVariables((array) Arr::get($theme, ThemeConfigSection::Fonts->value, [])),
                $this->normalizeCssVariables(
                    (array) Arr::get($theme, ThemeConfigSection::Tokens->value.'.'.ThemeTokenSection::Shared->value, []),
                ),
                $this->normalizeCssVariables(
                    (array) Arr::get($theme, ThemeConfigSection::Tokens->value.'.'.ThemeTokenSection::Light->value, []),
                ),
            ),
            'dark' => $this->normalizeCssVariables(
                (array) Arr::get($theme, ThemeConfigSection::Tokens->value.'.'.ThemeTokenSection::Dark->value, []),
            ),
        ];
    }

    protected function resolveFontVariables(array $fonts): array
    {
        $resolved = [];

        foreach (ThemeFontSlot::cases() as $fontSlot) {
            $fontValue = Arr::get($fonts, $fontSlot->value);

            if (filled($fontValue)) {
                $resolved[$fontSlot->cssVariable()] = (string) $fontValue;
            }
        }

        return $resolved;
    }

    protected function normalizeCssVariables(array $variables): array
    {
        $resolved = [];

        foreach ($variables as $key => $value) {
            if (blank($value) && ($value !== 0) && ($value !== '0')) {
                continue;
            }

            if ($value instanceof BackedEnum) {
                $value = $value->value;
            }

            $resolved[Str::start((string) $key, '--')] = (string) $value;
        }

        return $resolved;
    }
}
