<?php

namespace Kashyap\Vesper\Support\Configuration;

use Kashyap\Vesper\Enums\ThemeConfigSection;

class ResolvedThemeFactory
{
    public function __construct(
        private readonly ThemeSectionMerger $sectionMerger,
    ) {}

    public function build(array $config): array
    {
        $presetCatalog = new ThemePresetCatalog($config);
        $sections = $this->sectionMerger->merge(
            $presetCatalog->fallbackDefinition(),
            $presetCatalog->selectedDefinition(),
            $config,
        );

        return [
            'preset' => $presetCatalog->selectedName(),
            ThemeConfigSection::Fonts->value => $sections[ThemeConfigSection::Fonts->value],
            ThemeConfigSection::Layout->value => $sections[ThemeConfigSection::Layout->value],
            ThemeConfigSection::Branding->value => $sections[ThemeConfigSection::Branding->value],
            ThemeConfigSection::Header->value => $sections[ThemeConfigSection::Header->value],
            ThemeConfigSection::Sidebar->value => $sections[ThemeConfigSection::Sidebar->value],
            ThemeConfigSection::Colors->value => $sections[ThemeConfigSection::Colors->value],
            ThemeConfigSection::Tokens->value => $sections[ThemeConfigSection::Tokens->value],
        ];
    }
}
