<?php

use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;

it('prepends the package filament panels override path', function (): void {
    $hints = View::getFinder()->getHints();

    expect($hints)->toHaveKey('filament-panels');
    expect(realpath($hints['filament-panels'][0]))->toBe(realpath(dirname(__DIR__).'/resources/views/filament-panels'));
});

it('prepends the package filament override path', function (): void {
    $hints = View::getFinder()->getHints();

    expect($hints)->toHaveKey('filament');
    expect(realpath($hints['filament'][0]))->toBe(realpath(dirname(__DIR__).'/resources/views/filament'));
});

it('prepends the package filament notifications override path', function (): void {
    $hints = View::getFinder()->getHints();

    expect($hints)->toHaveKey('filament-notifications');
    expect(realpath($hints['filament-notifications'][0]))->toBe(realpath(dirname(__DIR__).'/resources/views/filament-notifications'));
});

it('includes realtime toast handling in the notifications override', function (): void {
    $contents = file_get_contents(dirname(__DIR__).'/resources/views/filament-notifications/database-notifications.blade.php');

    expect($contents)
        ->toContain('window.vesperDatabaseNotifications')
        ->toContain('new window.FilamentNotification()')
        ->toContain('window.alert(');
});

it('renders the package simple header override for auth pages', function (): void {
    $rendered = View::make('filament-panels::components.header.simple', [
        'heading' => 'Sign in',
        'logo' => true,
        'subheading' => 'Access your account',
    ])->render();

    expect($rendered)
        ->toContain('vs-auth-brand')
        ->toContain(config('vesper.branding.name'))
        ->toContain(config('vesper.branding.mark'))
        ->toContain('Sign in');
});

it('renders the package modal override from the filament namespace', function (): void {
    $rendered = View::make('filament::components.modal.index', [
        'heading' => 'Put Project On Hold',
        'description' => 'This will pause all work on this project.',
        'icon' => Heroicon::ExclamationTriangle,
        'iconColor' => 'warning',
        'id' => 'confirmation-modal',
        'slot' => new HtmlString(''),
        'footerActions' => [
            new HtmlString('<button class="fi-btn" type="button">Cancel</button>'),
            new HtmlString('<button class="fi-btn fi-color fi-color-warning" type="button">Continue</button>'),
        ],
    ])->render();

    expect($rendered)
        ->toContain('fi-modal-header')
        ->toContain('fi-modal-close-btn')
        ->toContain('fi-modal-footer')
        ->toContain('fi-modal-footer-actions')
        ->toContain('vs-confirmation-modal')
        ->toContain('vs-confirmation-modal-window')
        ->toContain('vs-confirmation-modal-actions')
        ->not->toContain('vs-confirmation-modal-header')
        ->not->toContain('vs-confirmation-modal-footer');
});
