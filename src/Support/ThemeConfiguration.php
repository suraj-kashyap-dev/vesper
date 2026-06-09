<?php

namespace Kashyap\Vesper\Support;

use Kashyap\Vesper\Enums\ThemeConfigSection;
use Kashyap\Vesper\Support\Configuration\CssVariableResolver;
use Kashyap\Vesper\Support\Configuration\PanelOptionsResolver;
use Kashyap\Vesper\Support\Configuration\ResolvedThemeFactory;
use Kashyap\Vesper\Support\Configuration\ThemeModeResolver;
use Kashyap\Vesper\Support\Configuration\ThemeSectionMerger;
use Kashyap\Vesper\VesperPlugin;

class ThemeConfiguration
{
    /**
     * @param  array<string, mixed>|null  $theme
     * @return array<string, mixed>
     */
    public static function resolve(?array $theme = null): array
    {
        return (new ResolvedThemeFactory(new ThemeSectionMerger))
            ->build(static::themeDefinition($theme));
    }

    /**
     * @param  array<string, mixed>|null  $theme
     * @return array<string, mixed>
     */
    public static function resolvePanelOptions(?array $theme = null): array
    {
        return (new PanelOptionsResolver(new ThemeModeResolver))
            ->resolve(static::resolve($theme)[ThemeConfigSection::Layout->value]);
    }

    /**
     * @param  array<string, mixed>|null  $theme
     * @return array<string, mixed>
     */
    public static function resolveSemanticColors(?array $theme = null): array
    {
        return static::resolve($theme)[ThemeConfigSection::Colors->value];
    }

    /**
     * @param  array<string, mixed>|null  $theme
     * @return array<string, mixed>
     */
    public static function resolveCssVariableSections(?array $theme = null): array
    {
        return (new CssVariableResolver)->resolve(static::resolve($theme));
    }

    /**
     * Resolve the theme definition to build from: an explicitly passed array,
     * the current panel's plugin, or a fresh plugin honoring published config.
     *
     * @param  array<string, mixed>|null  $theme
     * @return array<string, mixed>
     */
    protected static function themeDefinition(?array $theme): array
    {
        if ($theme !== null) {
            return $theme;
        }

        return (VesperPlugin::current() ?? VesperPlugin::make())->toThemeArray();
    }
}
