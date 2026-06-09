<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class SunsetPreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Sunset->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'orange',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'rose',
            'info' => 'sky',
            'gray' => 'stone',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(249, 115, 22, 0.45)',
                'vs-ring-soft' => 'rgba(249, 115, 22, 0.1)',
                'vs-accent' => '#f97316',
                'vs-accent-strong' => '#ea580c',
                'vs-accent-soft' => 'rgba(249, 115, 22, 0.16)',
                'vs-accent-muted' => 'rgba(249, 115, 22, 0.06)',
                'vs-accent-glow' => 'rgba(249, 115, 22, 0.24)',
                'vs-accent-rgb' => '249 115 22',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.12)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.12)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#fb7185',
                'vs-danger-soft' => 'rgba(251, 113, 133, 0.12)',
                'vs-danger-rgb' => '251 113 133',
                'vs-brand-gradient-start' => '#f97316',
                'vs-brand-gradient-end' => '#fb7185',
                'vs-avatar-gradient-start' => '#f97316',
                'vs-avatar-gradient-end' => '#fbbf24',
            ],
            'light' => [
                'vs-bg' => '#fff9f6',
                'vs-surface-1' => '#fffdfb',
                'vs-surface-2' => '#fbf3ee',
                'vs-surface-3' => '#f5e8de',
                'vs-surface-4' => '#ead9cc',
                'vs-border' => 'rgba(124, 45, 18, 0.06)',
                'vs-border-strong' => 'rgba(124, 45, 18, 0.1)',
                'vs-shadow' => '0 18px 40px rgba(124, 45, 18, 0.09)',
                'vs-shadow-soft' => '0 8px 18px rgba(124, 45, 18, 0.05)',
                'vs-text' => '#4a2618',
                'vs-text-2' => '#77584a',
                'vs-text-3' => '#b19483',
                'vs-accent-2' => '#f97316',
            ],
            'dark' => [
                'vs-accent-2' => '#fdba74',
            ],
        ];
    }
}
