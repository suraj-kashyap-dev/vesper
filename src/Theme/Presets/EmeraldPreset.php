<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class EmeraldPreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Emerald->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'emerald',
            'success' => 'green',
            'warning' => 'amber',
            'danger' => 'red',
            'info' => 'cyan',
            'gray' => 'stone',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(16, 185, 129, 0.45)',
                'vs-ring-soft' => 'rgba(16, 185, 129, 0.12)',
                'vs-accent' => '#10b981',
                'vs-accent-strong' => '#059669',
                'vs-accent-soft' => 'rgba(16, 185, 129, 0.14)',
                'vs-accent-muted' => 'rgba(16, 185, 129, 0.05)',
                'vs-accent-glow' => 'rgba(16, 185, 129, 0.24)',
                'vs-accent-rgb' => '16 185 129',
                'vs-success' => '#22c55e',
                'vs-success-soft' => 'rgba(34, 197, 94, 0.12)',
                'vs-success-rgb' => '34 197 94',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.12)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#ef4444',
                'vs-danger-soft' => 'rgba(239, 68, 68, 0.12)',
                'vs-danger-rgb' => '239 68 68',
                'vs-brand-gradient-start' => '#10b981',
                'vs-brand-gradient-end' => '#0f766e',
                'vs-avatar-gradient-start' => '#10b981',
                'vs-avatar-gradient-end' => '#22d3ee',
            ],
            'light' => [
                'vs-bg' => '#f7fbf8',
                'vs-surface-1' => '#fcfdfc',
                'vs-surface-2' => '#f2f7f4',
                'vs-surface-3' => '#e8efeb',
                'vs-surface-4' => '#dde6e1',
                'vs-border' => 'rgba(6, 78, 59, 0.09)',
                'vs-border-strong' => 'rgba(6, 78, 59, 0.15)',
                'vs-shadow' => '0 18px 40px rgba(6, 78, 59, 0.1)',
                'vs-shadow-soft' => '0 8px 18px rgba(6, 78, 59, 0.06)',
                'vs-text' => '#1b3228',
                'vs-text-2' => '#3d564b',
                'vs-text-3' => '#6f867b',
                'vs-text-4' => 'rgba(61, 86, 75, 0.72)',
                'vs-accent-2' => '#10b981',
            ],
            'dark' => [
                'vs-accent-2' => '#6ee7b7',
            ],
        ];
    }
}
