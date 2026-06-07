<?php

namespace Kashyap\Vesper\Support;

use Kashyap\Vesper\Enums\ThemeConfigSection;
use Kashyap\Vesper\Support\Configuration\CssVariableResolver;
use Kashyap\Vesper\Support\Configuration\PanelOptionsResolver;
use Kashyap\Vesper\Support\Configuration\ResolvedThemeFactory;
use Kashyap\Vesper\Support\Configuration\ThemeModeResolver;
use Kashyap\Vesper\Support\Configuration\ThemeSectionMerger;

class ThemeConfiguration
{
    public static function resolve(): array
    {
        return (new ResolvedThemeFactory(new ThemeSectionMerger))
            ->build(config('vesper', []));
    }

    public static function resolvePanelOptions(): array
    {
        return (new PanelOptionsResolver(new ThemeModeResolver))
            ->resolve(static::resolve()[ThemeConfigSection::Layout->value]);
    }

    public static function resolveSemanticColors(): array
    {
        return static::resolve()[ThemeConfigSection::Colors->value];
    }

    public static function resolveCssVariableSections(): array
    {
        return (new CssVariableResolver)->resolve(static::resolve());
    }
}
