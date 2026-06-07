<?php

namespace Kashyap\Vesper\Support\Configuration;

use Filament\Enums\ThemeMode;
use Illuminate\Support\Str;

class ThemeModeResolver
{
    public function resolve(mixed $mode): ThemeMode
    {
        if ($mode instanceof ThemeMode) {
            return $mode;
        }

        if (is_string($mode)) {
            $resolvedMode = ThemeMode::tryFrom(Str::lower($mode));

            if ($resolvedMode) {
                return $resolvedMode;
            }
        }

        return ThemeMode::System;
    }
}
