<?php

namespace Kashyap\Vesper\Support\Configuration;

use Illuminate\Support\Arr;
use Kashyap\Vesper\Enums\ThemeLayoutOption;

class PanelOptionsResolver
{
    public function __construct(
        private readonly ThemeModeResolver $themeModeResolver,
    ) {}

    public function resolve(array $layout): array
    {
        return [
            'defaultThemeMode' => $this->themeModeResolver->resolve($this->get($layout, ThemeLayoutOption::DefaultThemeMode)),
            'topNavigation' => (bool) $this->get($layout, ThemeLayoutOption::TopNavigation),
            'sidebarWidth' => (string) $this->get($layout, ThemeLayoutOption::SidebarWidth),
            'collapsedSidebarWidth' => (string) $this->get($layout, ThemeLayoutOption::CollapsedSidebarWidth),
            'sidebarCollapsibleOnDesktop' => (bool) $this->get($layout, ThemeLayoutOption::SidebarCollapsibleOnDesktop),
            'sidebarFullyCollapsibleOnDesktop' => (bool) $this->get($layout, ThemeLayoutOption::SidebarFullyCollapsibleOnDesktop),
            'collapsibleNavigationGroups' => (bool) $this->get($layout, ThemeLayoutOption::CollapsibleNavigationGroups),
            'globalSearchKeyBindings' => array_values(array_filter(
                (array) $this->get($layout, ThemeLayoutOption::GlobalSearchKeyBindings),
                fn (mixed $binding): bool => filled($binding),
            )),
            'showGlobalSearchKeyBindingSuffix' => (bool) $this->get($layout, ThemeLayoutOption::ShowGlobalSearchKeyBindingSuffix),
            'globalSearchDebounce' => $this->get($layout, ThemeLayoutOption::GlobalSearchDebounce),
            'maxContentWidth' => $this->get($layout, ThemeLayoutOption::MaxContentWidth),
            'simplePageMaxContentWidth' => $this->get($layout, ThemeLayoutOption::SimplePageMaxContentWidth),
        ];
    }

    protected function get(array $layout, ThemeLayoutOption $option): mixed
    {
        return Arr::get($layout, $option->key(), $option->default());
    }
}
