<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Enums\ThemePreset;

class SapphirePreset extends AbstractPreset
{
    public function key(): string
    {
        return ThemePreset::Sapphire->value;
    }

    public function colors(): array
    {
        return [
            'primary' => 'blue',
            'success' => 'emerald',
            'warning' => 'amber',
            'danger' => 'red',
            'info' => 'sky',
            'gray' => 'slate',
        ];
    }

    protected function paletteTokens(): array
    {
        return [
            'shared' => [
                'vs-ring' => 'rgba(37, 99, 235, 0.42)',
                'vs-ring-soft' => 'rgba(37, 99, 235, 0.1)',
                'vs-accent' => '#2563eb',
                'vs-accent-strong' => '#1d4ed8',
                'vs-accent-soft' => 'rgba(37, 99, 235, 0.13)',
                'vs-accent-muted' => 'rgba(37, 99, 235, 0.04)',
                'vs-accent-glow' => 'rgba(37, 99, 235, 0.2)',
                'vs-accent-rgb' => '37 99 235',
                'vs-success' => '#10b981',
                'vs-success-soft' => 'rgba(16, 185, 129, 0.1)',
                'vs-success-rgb' => '16 185 129',
                'vs-warning' => '#f59e0b',
                'vs-warning-soft' => 'rgba(245, 158, 11, 0.1)',
                'vs-warning-rgb' => '245 158 11',
                'vs-danger' => '#ef4444',
                'vs-danger-soft' => 'rgba(239, 68, 68, 0.1)',
                'vs-danger-rgb' => '239 68 68',
                'vs-brand-gradient-start' => '#2563eb',
                'vs-brand-gradient-end' => '#1e3a8a',
                'vs-avatar-gradient-start' => '#3b82f6',
                'vs-avatar-gradient-end' => '#60a5fa',
            ],
            'light' => [
                'vs-bg' => '#f6f8fb',
                'vs-surface-1' => '#fbfcfe',
                'vs-surface-2' => '#f1f4f8',
                'vs-surface-3' => '#e7ebf2',
                'vs-surface-4' => '#dce2eb',
                'vs-border' => 'rgba(30, 58, 138, 0.06)',
                'vs-border-strong' => 'rgba(30, 58, 138, 0.1)',
                'vs-shadow' => '0 18px 40px rgba(30, 58, 138, 0.09)',
                'vs-shadow-soft' => '0 8px 18px rgba(30, 58, 138, 0.05)',
                'vs-text' => '#21344d',
                'vs-text-2' => '#576983',
                'vs-text-3' => '#8ea3bd',
                'vs-accent-2' => '#1d4ed8',
            ],
            'dark' => [
                'vs-accent-2' => '#93c5fd',
            ],
        ];
    }
}
