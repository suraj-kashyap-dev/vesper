<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

/**
 * Cobalt — a calm, modern blue palette. It leans cooler and a touch softer than
 * Sapphire: icy blue-tinted surfaces in light mode and a confident azure accent
 * that stays comfortable to look at for long sessions.
 */
class CobaltPreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Cobalt->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'blue',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'rose',
            'info' => 'cyan',
            'gray' => 'slate',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(45, 91, 227, 0.4)',
                'vs-ring-soft' => 'rgba(45, 91, 227, 0.1)',
                'vs-accent' => '#2d5be3',
                'vs-accent-strong' => '#1e44c4',
                'vs-accent-soft' => 'rgba(45, 91, 227, 0.13)',
                'vs-accent-muted' => 'rgba(45, 91, 227, 0.04)',
                'vs-accent-glow' => 'rgba(45, 91, 227, 0.22)',
                'vs-accent-rgb' => '45 91 227',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.1)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.1)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#f43f5e',
                'vs-danger-soft' => 'rgba(244, 63, 94, 0.1)',
                'vs-danger-rgb' => '244 63 94',
                'vs-brand-gradient-start' => '#2d5be3',
                'vs-brand-gradient-end' => '#15267f',
                'vs-avatar-gradient-start' => '#3b6fe0',
                'vs-avatar-gradient-end' => '#6aa1ff',
            ],
            'light' => [
                'vs-bg' => '#f5f7fc',
                'vs-surface-1' => '#fbfcfe',
                'vs-surface-2' => '#eef2fa',
                'vs-surface-3' => '#e3e9f6',
                'vs-surface-4' => '#d6def0',
                'vs-border' => 'rgba(30, 44, 138, 0.07)',
                'vs-border-strong' => 'rgba(30, 44, 138, 0.11)',
                'vs-shadow' => '0 18px 40px rgba(30, 44, 138, 0.1)',
                'vs-shadow-soft' => '0 8px 18px rgba(30, 44, 138, 0.06)',
                'vs-text' => '#1d2942',
                'vs-text-2' => '#505f7e',
                'vs-text-3' => '#8693b0',
                'vs-accent-2' => '#1e44c4',
            ],
            'dark' => [
                'vs-accent-2' => '#8fb4ff',
            ],
        ];
    }
}
