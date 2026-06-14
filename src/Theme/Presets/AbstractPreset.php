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
                'vs-bg' => '#15161a',
                'vs-bg-rgb' => '21 22 26',
                'vs-surface-1' => '#1b1c21',
                'vs-surface-2' => '#212329',
                'vs-surface-3' => '#2a2c33',
                'vs-surface-4' => '#33353d',
                'vs-surface-5' => '#3d3f48',
                'vs-border' => 'rgba(255, 255, 255, 0.07)',
                'vs-border-strong' => 'rgba(255, 255, 255, 0.13)',
                'vs-shadow' => '0 30px 80px rgba(0, 0, 0, 0.55)',
                'vs-shadow-soft' => '0 16px 32px rgba(0, 0, 0, 0.38)',
                'vs-shadow-card' => '0 18px 40px rgba(0, 0, 0, 0.3)',
                'vs-text' => '#e7e8ec',
                'vs-text-2' => '#bbbec8',
                'vs-text-3' => '#8d909d',
                'vs-text-4' => 'rgba(187, 190, 200, 0.6)',
                'vs-tooltip-bg' => 'linear-gradient(180deg, rgba(33, 35, 41, 0.98), rgba(21, 22, 26, 0.96))',
                'vs-tooltip-border' => 'rgba(255, 255, 255, 0.12)',
                'vs-tooltip-text' => '#ececf0',
                'vs-tooltip-shadow' => '0 24px 56px rgba(0, 0, 0, 0.4)',
                'vs-tooltip-arrow' => '#212329',
            ],
        ];
    }
}
