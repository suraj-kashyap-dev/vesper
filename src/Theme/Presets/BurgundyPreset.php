<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class BurgundyPreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Burgundy->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'rose',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'red',
            'info' => 'pink',
            'gray' => 'stone',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(159, 18, 57, 0.38)',
                'vs-ring-soft' => 'rgba(159, 18, 57, 0.09)',
                'vs-accent' => '#9f1239',
                'vs-accent-strong' => '#881337',
                'vs-accent-soft' => 'rgba(159, 18, 57, 0.12)',
                'vs-accent-muted' => 'rgba(159, 18, 57, 0.04)',
                'vs-accent-glow' => 'rgba(159, 18, 57, 0.18)',
                'vs-accent-rgb' => '159 18 57',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.09)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.09)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#dc2626',
                'vs-danger-soft' => 'rgba(220, 38, 38, 0.09)',
                'vs-danger-rgb' => '220 38 38',
                'vs-brand-gradient-start' => '#9f1239',
                'vs-brand-gradient-end' => '#4c0519',
                'vs-avatar-gradient-start' => '#be123c',
                'vs-avatar-gradient-end' => '#fb7185',
            ],
            'light' => [
                'vs-bg' => '#fdf8f9',
                'vs-surface-1' => '#fffdfd',
                'vs-surface-2' => '#faf2f4',
                'vs-surface-3' => '#f3e7ea',
                'vs-surface-4' => '#e9dadd',
                'vs-border' => 'rgba(76, 5, 25, 0.06)',
                'vs-border-strong' => 'rgba(76, 5, 25, 0.1)',
                'vs-shadow' => '0 18px 40px rgba(76, 5, 25, 0.08)',
                'vs-shadow-soft' => '0 8px 18px rgba(76, 5, 25, 0.04)',
                'vs-text' => '#4a2430',
                'vs-text-2' => '#7a5360',
                'vs-text-3' => '#b29099',
                'vs-accent-2' => '#881337',
            ],
            'dark' => [
                'vs-accent-2' => '#fda4af',
            ],
        ];
    }
}
