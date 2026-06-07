<?php

namespace Kashyap\Vesper;

use Filament\Support\Assets\Theme;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\View;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VesperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('vesper')
            ->hasConfigFile('vesper')
            ->hasViews('vesper');
    }

    public function packageBooted(): void
    {
        $this->registerFilamentAssets();
        $this->registerViewOverrides();
        $this->registerHooks();
    }

    protected function registerViewOverrides(): void
    {
        if (! config('vesper.override_filament_panels_views', true)) {
            return;
        }

        $basePath = __DIR__.'/../resources/views';

        View::addNamespace('vesper', $basePath);

        foreach ([
            'filament' => $basePath.'/filament',
            'filament-notifications' => $basePath.'/filament-notifications',
            'filament-panels' => $basePath.'/filament-panels',
        ] as $namespace => $path) {
            if (! is_dir($path)) {
                continue;
            }

            View::prependNamespace($namespace, $path);
        }
    }

    protected function registerFilamentAssets(): void
    {
        FilamentAsset::register([
            Theme::make(
                config('vesper.theme_id', 'vesper'),
                __DIR__.'/../dist/'.config('vesper.theme_asset', 'vesper.css'),
            ),
        ], 'suraj-kashyap-dev/vesper');
    }

    protected function registerHooks(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => view('vesper::hooks.vesper-primary-color-override')->render(),
        );
    }
}
