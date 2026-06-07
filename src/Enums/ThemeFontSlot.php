<?php

namespace Kashyap\Vesper\Enums;

enum ThemeFontSlot: string
{
    case Body = 'body';
    case Mono = 'mono';
    case Heading = 'heading';

    public function cssVariable(): string
    {
        return match ($this) {
            self::Body => '--font-family',
            self::Mono => '--mono-font-family',
            self::Heading => '--serif-font-family',
        };
    }
}
