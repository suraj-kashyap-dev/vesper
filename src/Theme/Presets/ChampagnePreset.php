<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class ChampagnePreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Champagne->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'yellow',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'red',
            'info' => 'orange',
            'gray' => 'warm',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(202, 138, 4, 0.32)',
                'vs-ring-soft' => 'rgba(202, 138, 4, 0.08)',
                'vs-accent' => '#ca8a04',
                'vs-accent-strong' => '#a16207',
                'vs-accent-soft' => 'rgba(202, 138, 4, 0.11)',
                'vs-accent-muted' => 'rgba(202, 138, 4, 0.04)',
                'vs-accent-glow' => 'rgba(202, 138, 4, 0.16)',
                'vs-accent-rgb' => '202 138 4',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.09)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.09)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#ef4444',
                'vs-danger-soft' => 'rgba(239, 68, 68, 0.09)',
                'vs-danger-rgb' => '239 68 68',
                'vs-brand-gradient-start' => '#eab308',
                'vs-brand-gradient-end' => '#ca8a04',
                'vs-avatar-gradient-start' => '#fef08a',
                'vs-avatar-gradient-end' => '#fde047',
            ],
            'light' => [
                'vs-bg' => '#fdfcf8',
                'vs-surface-1' => '#fffefb',
                'vs-surface-2' => '#fbf7ef',
                'vs-surface-3' => '#f4eddf',
                'vs-surface-4' => '#e9dfcf',
                'vs-border' => 'rgba(113, 63, 18, 0.05)',
                'vs-border-strong' => 'rgba(113, 63, 18, 0.09)',
                'vs-shadow' => '0 16px 34px rgba(113, 63, 18, 0.06)',
                'vs-shadow-soft' => '0 6px 14px rgba(113, 63, 18, 0.03)',
                'vs-text' => '#4a3824',
                'vs-text-2' => '#766454',
                'vs-text-3' => '#b09d87',
                'vs-accent-2' => '#a16207',
            ],
            'dark' => [
                'vs-accent-2' => '#facc15',
            ],
        ];
    }
}
