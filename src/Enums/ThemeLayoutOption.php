<?php

namespace Kashyap\Vesper\Enums;

use Filament\Enums\ThemeMode;

enum ThemeLayoutOption
{
    case DefaultThemeMode;
    case TopNavigation;
    case SidebarWidth;
    case CollapsedSidebarWidth;
    case SidebarCollapsibleOnDesktop;
    case SidebarFullyCollapsibleOnDesktop;
    case CollapsibleNavigationGroups;
    case GlobalSearchKeyBindings;
    case ShowGlobalSearchKeyBindingSuffix;
    case GlobalSearchDebounce;
    case MaxContentWidth;
    case SimplePageMaxContentWidth;

    public function key(): string
    {
        return match ($this) {
            self::DefaultThemeMode => 'default_theme_mode',
            self::TopNavigation => 'top_navigation',
            self::SidebarWidth => 'sidebar_width',
            self::CollapsedSidebarWidth => 'collapsed_sidebar_width',
            self::SidebarCollapsibleOnDesktop => 'sidebar_collapsible_on_desktop',
            self::SidebarFullyCollapsibleOnDesktop => 'sidebar_fully_collapsible_on_desktop',
            self::CollapsibleNavigationGroups => 'collapsible_navigation_groups',
            self::GlobalSearchKeyBindings => 'global_search_key_bindings',
            self::ShowGlobalSearchKeyBindingSuffix => 'show_global_search_key_binding_suffix',
            self::GlobalSearchDebounce => 'global_search_debounce',
            self::MaxContentWidth => 'max_content_width',
            self::SimplePageMaxContentWidth => 'simple_page_max_content_width',
        };
    }

    public function default(): mixed
    {
        return match ($this) {
            self::DefaultThemeMode => ThemeMode::System,
            self::TopNavigation => false,
            self::SidebarWidth => '252px',
            self::CollapsedSidebarWidth => '72px',
            self::SidebarCollapsibleOnDesktop => true,
            self::SidebarFullyCollapsibleOnDesktop => false,
            self::CollapsibleNavigationGroups => false,
            self::GlobalSearchKeyBindings => ['mod+k'],
            self::ShowGlobalSearchKeyBindingSuffix => true,
            self::GlobalSearchDebounce => null,
            self::MaxContentWidth => null,
            self::SimplePageMaxContentWidth => null,
        };
    }
}
