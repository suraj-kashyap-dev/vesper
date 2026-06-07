<?php

namespace Kashyap\Vesper\Enums;

enum ThemeConfigSection: string
{
    case Layout = 'layout';
    case Fonts = 'fonts';
    case Branding = 'branding';
    case Header = 'header';
    case Sidebar = 'sidebar';
    case Colors = 'colors';
    case Tokens = 'tokens';
    case Presets = 'presets';

    public static function mergeableSections(): array
    {
        return [
            self::Fonts,
            self::Layout,
            self::Branding,
            self::Header,
            self::Sidebar,
            self::Colors,
        ];
    }
}
