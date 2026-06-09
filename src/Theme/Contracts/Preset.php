<?php

namespace Kashyap\Vesper\Theme\Contracts;

interface Preset
{
    /**
     * The unique preset key (a ThemePreset enum value or a custom slug).
     */
    public function key(): string;

    /**
     * The semantic Filament color map (primary, success, warning, danger, info, gray).
     *
     * @return array<string, string>
     */
    public function colors(): array;

    /**
     * The CSS token sets keyed by section.
     *
     * @return array{shared: array<string, string>, light: array<string, string>, dark: array<string, string>}
     */
    public function tokens(): array;
}
