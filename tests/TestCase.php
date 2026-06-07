<?php

namespace Kashyap\Vesper\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Panel;
use Filament\Support\SupportServiceProvider;
use Kashyap\Vesper\VesperPlugin;
use Kashyap\Vesper\VesperServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $panel = Panel::make()
            ->default()
            ->id('admin')
            ->plugin(VesperPlugin::make());

        Filament::registerPanel($panel);
        Filament::setCurrentPanel($panel);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(str_repeat('a', 32)));
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            LivewireServiceProvider::class,
            SupportServiceProvider::class,
            FilamentServiceProvider::class,
            VesperServiceProvider::class,
        ];
    }
}
