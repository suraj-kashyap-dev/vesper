<?php

use Illuminate\Support\Facades\View;

it('renders static theme customization markup from config', function (): void {
    config()->set('vesper.preset', 'emerald');
    config()->set('vesper.fonts.stylesheet', 'https://example.com/fonts.css');

    $rendered = View::make('vesper::hooks.theme-customization')->render();

    expect($rendered)
        ->toContain('data-vesper-preset="emerald"')
        ->toContain('https://example.com/fonts.css')
        ->toContain(':root')
        ->toContain('html.dark')
        ->toContain('--vs-surface-1: #fcfdfc;')
        ->toContain('--vs-text: #1b3228;')
        ->not->toContain('--vs-surface-1: #ffffff;')
        ->not->toContain('data-vesper-runtime-preset')
        ->not->toContain('data-vesper-runtime-fonts')
        ->not->toContain('vesper-demo-preset')
        ->not->toContain('VesperDemoThemeSwitcher')
        ->not->toContain('livewire:navigated');
});
