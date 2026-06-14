<?php

namespace Kashyap\Vesper\Enums;

enum ThemePreset: string
{
    case Emerald = 'emerald';
    case Sunset = 'sunset';
    case Amethyst = 'amethyst';
    case Burgundy = 'burgundy';
    case Champagne = 'champagne';
    case Obsidian = 'obsidian';
    case Platinum = 'platinum';
    case Sapphire = 'sapphire';
    case Cobalt = 'cobalt';

    public static function fallback(): self
    {
        return self::Sapphire;
    }

    public static function values(): array
    {
        return array_map(
            static fn (self $preset): string => $preset->value,
            self::cases(),
        );
    }
}
