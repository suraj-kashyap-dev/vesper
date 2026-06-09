<?php

namespace Kashyap\Vesper\Theme;

use Kashyap\Vesper\Enums\ThemePreset;

class ThemeDefaults
{
    public const THEME_ID = 'vesper';

    public const THEME_ASSET = 'vesper.css';

    public const FONT_STYLESHEET = 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap';

    public static function preset(): string
    {
        return ThemePreset::fallback()->value;
    }

    /**
     * @return array<string, string|null>
     */
    public static function fonts(): array
    {
        return [
            'body' => "'Plus Jakarta Sans', sans-serif",
            'mono' => "'Geist Mono', monospace",
            'heading' => "'Space Grotesk', sans-serif",
            'stylesheet' => self::FONT_STYLESHEET,
        ];
    }

    /**
     * @return array<string, string|null>
     */
    public static function branding(): array
    {
        return [
            'name' => null,
            'eyebrow' => 'Admin Panel',
            'mark' => null,
        ];
    }

    /**
     * @return array{help_url: string|null, show_help_url: bool, show_theme_toggle: bool}
     */
    public static function header(): array
    {
        return [
            'help_url' => null,
            'show_help_url' => true,
            'show_theme_toggle' => true,
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function sidebar(): array
    {
        return [
            'overview_label' => 'Overview',
            'user_role' => 'Administrator',
        ];
    }
}
