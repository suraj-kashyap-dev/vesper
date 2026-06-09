<?php

namespace Kashyap\Vesper\Theme\Presets;

use Kashyap\Vesper\Theme\Contracts\Preset;

abstract class AbstractPreset implements Preset
{
    /**
     * The preset-specific token overrides, keyed by section.
     *
     * @return array{shared?: array<string, string>, light?: array<string, string>, dark?: array<string, string>}
     */
    abstract protected function paletteTokens(): array;

    public function tokens(): array
    {
        /** @var array{shared: array<string, string>, light: array<string, string>, dark: array<string, string>} $tokens */
        $tokens = array_replace_recursive($this->foundationTokens(), $this->paletteTokens());

        return $tokens;
    }

    /**
     * Shared foundation tokens applied beneath every preset palette.
     *
     * @return array{shared: array<string, string>, light: array<string, string>, dark: array<string, string>}
     */
    protected function foundationTokens(): array
    {
        return [
            'shared' => [
                'vs-overlay' => 'rgba(0, 0, 0, 0.55)',
                'vs-topbar-h' => '56px',
                'vs-radius-sm' => '8px',
                'vs-radius-md' => '10px',
                'vs-radius-lg' => '12px',
                'vs-transition' => 'all 0.22s cubic-bezier(0.4, 0, 0.2, 1)',
            ],
            'light' => [
                'vs-surface-5' => '#d1dae6',
                'vs-shadow-card' => '0 10px 24px rgba(15, 23, 42, 0.06)',
                'vs-text-4' => 'rgba(88, 104, 123, 0.7)',
                'vs-tooltip-bg' => 'linear-gradient(180deg, rgba(251, 252, 254, 0.98), rgba(241, 245, 249, 0.96))',
                'vs-tooltip-border' => 'rgba(15, 23, 42, 0.08)',
                'vs-tooltip-text' => '#2f4055',
                'vs-tooltip-shadow' => '0 18px 36px rgba(15, 23, 42, 0.12)',
                'vs-tooltip-arrow' => '#f1f5f9',
            ],
            'dark' => [
                'vs-bg' => '#0a0a0a',
                'vs-bg-rgb' => '10 10 10',
                'vs-surface-1' => '#111111',
                'vs-surface-2' => '#171717',
                'vs-surface-3' => '#1f1f1f',
                'vs-surface-4' => '#262626',
                'vs-surface-5' => '#303030',
                'vs-border' => 'rgba(255, 255, 255, 0.055)',
                'vs-border-strong' => 'rgba(255, 255, 255, 0.1)',
                'vs-shadow' => '0 30px 80px rgba(0, 0, 0, 0.68)',
                'vs-shadow-soft' => '0 16px 32px rgba(0, 0, 0, 0.46)',
                'vs-shadow-card' => '0 18px 40px rgba(0, 0, 0, 0.34)',
                'vs-text' => '#fafafa',
                'vs-text-2' => '#d4d4d8',
                'vs-text-3' => '#71717a',
                'vs-text-4' => 'rgba(212, 212, 216, 0.58)',
                'vs-tooltip-bg' => 'linear-gradient(180deg, rgba(23, 23, 23, 0.98), rgba(10, 10, 10, 0.96))',
                'vs-tooltip-border' => 'rgba(255, 255, 255, 0.12)',
                'vs-tooltip-text' => '#f5f5f5',
                'vs-tooltip-shadow' => '0 24px 56px rgba(0, 0, 0, 0.42)',
                'vs-tooltip-arrow' => '#171717',
            ],
        ];
    }
}
