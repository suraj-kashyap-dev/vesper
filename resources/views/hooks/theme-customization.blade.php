@php
    $themeConfiguration = \Kashyap\Vesper\Support\ThemeConfiguration::resolveCssVariableSections();

    $rootDeclarations = collect($themeConfiguration['root'])
        ->map(fn (string $value, string $property): string => "{$property}: {$value};")
        ->implode("\n        ");

    $darkDeclarations = collect($themeConfiguration['dark'])
        ->map(fn (string $value, string $property): string => "{$property}: {$value};")
        ->implode("\n        ");
@endphp

@if (filled($themeConfiguration['fontStylesheet']))
    <link rel="stylesheet" href="{{ $themeConfiguration['fontStylesheet'] }}" data-vesper-fonts />
@endif

<style data-vesper-preset="{{ $themeConfiguration['preset'] }}">
    :root {
        {!! $rootDeclarations !!}
    }

    html.dark {
        {!! $darkDeclarations !!}
    }
</style>
