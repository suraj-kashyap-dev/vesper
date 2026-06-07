<?php

namespace Kashyap\Vesper\Support\Configuration;

use BackedEnum;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

class SemanticColorResolver
{
    public function resolve(array $colors): array
    {
        $resolved = [];

        foreach ($colors as $name => $color) {
            $resolved[$name] = $this->resolvePalette($color);
        }

        return $resolved;
    }

    protected function resolvePalette(array|string|BackedEnum $color): array
    {
        if (is_array($color)) {
            return $color;
        }

        if ($color instanceof BackedEnum) {
            $color = $color->value;
        }

        $constant = Color::class.'::'.Str::studly($color);

        if (defined($constant)) {
            return constant($constant);
        }

        return constant(Color::class.'::Gray');
    }
}
