<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class AmethystPreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Amethyst->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'violet',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'rose',
            'info' => 'indigo',
            'gray' => 'slate',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(139, 92, 246, 0.45)',
                'vs-ring-soft' => 'rgba(139, 92, 246, 0.1)',
                'vs-accent' => '#8b5cf6',
                'vs-accent-strong' => '#7c3aed',
                'vs-accent-soft' => 'rgba(139, 92, 246, 0.16)',
                'vs-accent-muted' => 'rgba(139, 92, 246, 0.06)',
                'vs-accent-glow' => 'rgba(139, 92, 246, 0.24)',
                'vs-accent-rgb' => '139 92 246',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.12)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.12)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#fb7185',
                'vs-danger-soft' => 'rgba(251, 113, 133, 0.12)',
                'vs-danger-rgb' => '251 113 133',
                'vs-brand-gradient-start' => '#8b5cf6',
                'vs-brand-gradient-end' => '#ec4899',
                'vs-avatar-gradient-start' => '#8b5cf6',
                'vs-avatar-gradient-end' => '#f472b6',
            ],
            'light' => [
                'vs-bg' => '#fbf8fd',
                'vs-surface-1' => '#fdfcff',
                'vs-surface-2' => '#f4f0fa',
                'vs-surface-3' => '#ebe5f3',
                'vs-surface-4' => '#dfd7ea',
                'vs-border' => 'rgba(76, 29, 149, 0.06)',
                'vs-border-strong' => 'rgba(76, 29, 149, 0.1)',
                'vs-shadow' => '0 18px 40px rgba(76, 29, 149, 0.09)',
                'vs-shadow-soft' => '0 8px 18px rgba(76, 29, 149, 0.05)',
                'vs-text' => '#392a52',
                'vs-text-2' => '#685b7d',
                'vs-text-3' => '#a294b6',
                'vs-accent-2' => '#8b5cf6',
            ],
            'dark' => [
                'vs-accent-2' => '#c4b5fd',
            ],
        ];
    }
}
