<?php

namespace Kashyap\Vesper;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Facades\FilamentAsset;
use Filament\View\PanelsRenderHook;
use Kashyap\Vesper\Support\Configuration\SemanticColorResolver;
use Kashyap\Vesper\Support\ThemeConfiguration;

class VesperPlugin implements Plugin
{
    public static function make(): static
    {
        return new static;
    }

    public function getId(): string
    {
        return 'vesper';
    }

    public function register(Panel $panel): void
    {
        $panelOptions = ThemeConfiguration::resolvePanelOptions();
        $themeId = (string) config('vesper.theme_id', $this->getId());

        FilamentAsset::register([
            Theme::make(
                $themeId,
                __DIR__.'/../dist/'.config('vesper.theme_asset', 'vesper.css'),
            ),
        ], 'suraj-kashyap-dev/vesper');

        $panel
            ->theme($themeId)
            ->defaultThemeMode($panelOptions['defaultThemeMode'])
            ->topNavigation($panelOptions['topNavigation'])
            ->sidebarWidth($panelOptions['sidebarWidth'])
            ->collapsedSidebarWidth($panelOptions['collapsedSidebarWidth'])
            ->sidebarCollapsibleOnDesktop($panelOptions['sidebarCollapsibleOnDesktop'])
            ->sidebarFullyCollapsibleOnDesktop($panelOptions['sidebarFullyCollapsibleOnDesktop'])
            ->collapsibleNavigationGroups($panelOptions['collapsibleNavigationGroups'])
            ->globalSearchDebounce($panelOptions['globalSearchDebounce'])
            ->globalSearchKeyBindings($panelOptions['globalSearchKeyBindings'])
            ->maxContentWidth($panelOptions['maxContentWidth'])
            ->simplePageMaxContentWidth($panelOptions['simplePageMaxContentWidth'])
            ->colors((new SemanticColorResolver)->resolve(ThemeConfiguration::resolveSemanticColors()))
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => view('vesper::hooks.theme-customization')->render(),
            );

        if ($panelOptions['showGlobalSearchKeyBindingSuffix']) {
            $panel->globalSearchFieldKeyBindingSuffix();
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
