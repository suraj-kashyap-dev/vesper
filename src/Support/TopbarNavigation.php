<?php

namespace Kashyap\Vesper\Support;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class TopbarNavigation
{
    public static function resolve(): array
    {
        [$group, $item, $parentItem] = static::findActiveNavigation();

        $brandLabel = config('vesper.branding.name');

        if (blank($brandLabel)) {
            $brandLabel = trim(strip_tags((string) Filament::getBrandName()));
        }

        return [
            'brandLabel' => $brandLabel ?: 'Filament',
            'currentLabel' => $item?->getLabel() ?? $group?->getLabel() ?? static::fallbackLabel(),
            'currentIcon' => $item?->getActiveIcon() ?? $item?->getIcon() ?? $parentItem?->getIcon() ?? $group?->getIcon() ?? Heroicon::OutlinedHome,
            'parentLabel' => $parentItem?->getLabel(),
            'groupLabel' => $group?->getLabel(),
        ];
    }

    protected static function findActiveNavigation(): array
    {
        if (! Filament::hasNavigation()) {
            return [null, null, null];
        }

        foreach (Filament::getNavigation() as $group) {
            [$item, $parentItem] = static::findActiveNavigationItem($group->getItems());

            if ($item) {
                return [$group, $item, $parentItem];
            }

            if ($group->isActive()) {
                return [$group, null, null];
            }
        }

        return [null, null, null];
    }

    protected static function findActiveNavigationItem(iterable $items, ?NavigationItem $parentItem = null): array
    {
        foreach ($items as $item) {
            if ($item->isActive()) {
                return [$item, $parentItem];
            }

            [$childItem, $childParentItem] = static::findActiveNavigationItem($item->getChildItems(), $item);

            if ($childItem) {
                return [$childItem, $childParentItem];
            }
        }

        return [null, null];
    }

    protected static function fallbackLabel(): string
    {
        $routeName = request()->route()?->getName();

        if (filled($routeName)) {
            return (string) Str::of($routeName)
                ->afterLast('.')
                ->replace(['-', '_'], ' ')
                ->headline();
        }

        return 'Overview';
    }
}
