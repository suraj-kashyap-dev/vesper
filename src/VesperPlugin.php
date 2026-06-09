<?php

namespace Kashyap\Vesper;

use Filament\Contracts\Plugin;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Assets\Theme;
use Filament\Support\Facades\FilamentAsset;
use Filament\View\PanelsRenderHook;
use Kashyap\Vesper\Enums\ThemePreset;
use Kashyap\Vesper\Support\Configuration\SemanticColorResolver;
use Kashyap\Vesper\Support\ThemeConfiguration;
use Kashyap\Vesper\Theme\Contracts\Preset;
use Kashyap\Vesper\Theme\PresetRepository;
use Kashyap\Vesper\Theme\StructuralTokens;
use Kashyap\Vesper\Theme\ThemeDefaults;
use Throwable;

final class VesperPlugin implements Plugin
{
    protected PresetRepository $presets;

    protected ?string $presetKey = null;

    protected ?string $themeId = null;

    protected ?string $themeAsset = null;

    protected array $brandingOverrides = [];

    protected array $headerOverrides = [];

    protected array $sidebarOverrides = [];

    protected array $fontOverrides = [];

    protected array $layoutOverrides = [];

    protected ?array $colorOverrides = null;

    protected array $tokenOverrides = [];

    public function __construct()
    {
        $this->presets = new PresetRepository;
    }

    public static function make(): static
    {
        return new self;
    }

    public function getId(): string
    {
        return 'vesper';
    }

    public static function current(): ?self
    {
        try {
            $plugin = Filament::getCurrentPanel()?->getPlugin('vesper');

            return $plugin instanceof self ? $plugin : null;
        } catch (Throwable) {
            return null;
        }
    }

    public function preset(ThemePreset|string $preset): static
    {
        $this->presetKey = $preset instanceof ThemePreset ? $preset->value : $preset;

        return $this;
    }

    public function registerPreset(Preset $preset): static
    {
        $this->presets->register($preset);

        return $this;
    }

    public function themeId(string $themeId): static
    {
        $this->themeId = $themeId;

        return $this;
    }

    public function themeAsset(string $themeAsset): static
    {
        $this->themeAsset = $themeAsset;

        return $this;
    }

    public function branding(?string $name = null, ?string $eyebrow = null, ?string $mark = null): static
    {
        $this->mergeOverrides($this->brandingOverrides, compact('name', 'eyebrow', 'mark'));

        return $this;
    }

    public function header(?string $helpUrl = null, ?bool $showThemeToggle = null, ?bool $showHelpUrl = null): static
    {
        $this->mergeOverrides($this->headerOverrides, [
            'help_url' => $helpUrl,
            'show_theme_toggle' => $showThemeToggle,
            'show_help_url' => $showHelpUrl,
        ]);

        return $this;
    }

    public function sidebar(?string $overviewLabel = null, ?string $userRole = null): static
    {
        $this->mergeOverrides($this->sidebarOverrides, [
            'overview_label' => $overviewLabel,
            'user_role' => $userRole,
        ]);

        return $this;
    }

    public function fonts(?string $body = null, ?string $mono = null, ?string $heading = null, ?string $stylesheet = null): static
    {
        $this->mergeOverrides($this->fontOverrides, compact('body', 'mono', 'heading', 'stylesheet'));

        return $this;
    }

    public function layout(array $options): static
    {
        $this->layoutOverrides = array_merge($this->layoutOverrides, $options);

        return $this;
    }

    public function colors(array $colors): static
    {
        $this->colorOverrides = array_merge($this->colorOverrides ?? [], $colors);

        return $this;
    }

    public function tokens(array $tokens): static
    {
        $this->tokenOverrides = array_replace_recursive($this->tokenOverrides, $tokens);

        return $this;
    }

    public function toThemeArray(): array
    {
        return [
            'theme_id' => $this->getThemeId(),
            'theme_asset' => $this->getThemeAsset(),
            'preset' => $this->getPresetKey(),
            'colors' => $this->colorOverrides ?? (array) config('vesper.colors', []),
            'tokens' => array_replace_recursive(
                StructuralTokens::all(),
                (array) config('vesper.tokens', []),
                $this->tokenOverrides,
            ),
            'presets' => array_replace_recursive(
                $this->presets->toArray(),
                (array) config('vesper.presets', []),
            ),
            'fonts' => $this->resolveSection('fonts', ThemeDefaults::fonts(), $this->fontOverrides),
            'layout' => array_merge((array) config('vesper.layout', []), $this->layoutOverrides),
            'branding' => $this->resolveSection('branding', ThemeDefaults::branding(), $this->brandingOverrides),
            'header' => $this->resolveSection('header', ThemeDefaults::header(), $this->headerOverrides),
            'sidebar' => $this->resolveSection('sidebar', ThemeDefaults::sidebar(), $this->sidebarOverrides),
        ];
    }

    public function getThemeId(): string
    {
        return $this->themeId ?? (string) config('vesper.theme_id', ThemeDefaults::THEME_ID);
    }

    public function getThemeAsset(): string
    {
        return $this->themeAsset ?? (string) config('vesper.theme_asset', ThemeDefaults::THEME_ASSET);
    }

    public function getPresetKey(): string
    {
        return $this->presetKey ?? (string) config('vesper.preset', ThemeDefaults::preset());
    }

    public function getBranding(string $key): mixed
    {
        return $this->resolveSection('branding', ThemeDefaults::branding(), $this->brandingOverrides)[$key] ?? null;
    }

    public function getHeader(string $key): mixed
    {
        return $this->resolveSection('header', ThemeDefaults::header(), $this->headerOverrides)[$key] ?? null;
    }

    public function getSidebar(string $key): mixed
    {
        return $this->resolveSection('sidebar', ThemeDefaults::sidebar(), $this->sidebarOverrides)[$key] ?? null;
    }

    public function getHelpUrl(): ?string
    {
        if (! $this->getHeader('show_help_url')) {
            return null;
        }

        $url = $this->getHeader('help_url');

        return filled($url) ? (string) $url : null;
    }

    public function showThemeToggle(): bool
    {
        return (bool) $this->getHeader('show_theme_toggle');
    }

    public function register(Panel $panel): void
    {
        $theme = $this->toThemeArray();
        $themeId = $this->getThemeId();
        $panelOptions = ThemeConfiguration::resolvePanelOptions($theme);

        FilamentAsset::register([
            Theme::make(
                $themeId,
                __DIR__.'/../dist/'.$this->getThemeAsset(),
            ),
        ], 'suraj-kashyap-dev/vesper');

        $panel
            ->theme($themeId)
            ->defaultThemeMode($panelOptions['defaultThemeMode'])
            ->topNavigation($panelOptions['topNavigation'])
            ->sidebarWidth($panelOptions['sidebarWidth'])
            ->collapsedSidebarWidth($panelOptions['collapsedSidebarWidth'])
            ->sidebarCollapsibleOnDesktop($panelOptions['sidebarCollapsibleOnDesktop'])
            ->sidebarFullyCollapsibleOnDesktop($panelOptions['sidebarFullyCollapsibleOnDesktop'])
            ->collapsibleNavigationGroups($panelOptions['collapsibleNavigationGroups'])
            ->globalSearchDebounce($panelOptions['globalSearchDebounce'])
            ->globalSearchKeyBindings($panelOptions['globalSearchKeyBindings'])
            ->maxContentWidth($panelOptions['maxContentWidth'])
            ->simplePageMaxContentWidth($panelOptions['simplePageMaxContentWidth'])
            ->colors((new SemanticColorResolver)->resolve(ThemeConfiguration::resolveSemanticColors($theme)))
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => view('vesper::hooks.theme-customization', ['plugin' => $this])->render(),
            );

        if ($panelOptions['showGlobalSearchKeyBindingSuffix']) {
            $panel->globalSearchFieldKeyBindingSuffix();
        }
    }

    public function boot(Panel $panel): void {}

    protected function mergeOverrides(array &$bucket, array $values): void
    {
        foreach ($values as $key => $value) {
            if ($value !== null) {
                $bucket[$key] = $value;
            }
        }
    }

    protected function resolveSection(string $section, array $defaults, array $overrides): array
    {
        return array_merge(
            $defaults,
            (array) config("vesper.{$section}", []),
            $overrides,
        );
    }
}
