@props([
    'heading' => null,
    'logo' => true,
    'subheading' => null,
])

@php
    $brandName = config('vesper.branding.name');
    $brandEyebrow = config('vesper.branding.eyebrow', 'Admin Panel');
    $brandMark = config('vesper.branding.mark');

    if (blank($brandName)) {
        $brandName = trim(strip_tags((string) filament()->getBrandName()));
    }

    if (blank($brandMark)) {
        $brandMark = (string) \Illuminate\Support\Str::of($brandName ?: 'Fi')
            ->replaceMatches('/[^A-Za-z0-9]/', '')
            ->substr(0, 2)
            ->upper();
    }
@endphp

<header class="fi-simple-header">
    @if ($logo)
        <div class="vs-auth-brand">
            <span class="sb-brand-icon vs-auth-brand-icon">
                {{ $brandMark }}
            </span>

            <span class="sb-brand-text">
                <span class="sb-brand-name">
                    {{ $brandName ?: 'Filament' }}
                </span>

                @if (filled($brandEyebrow))
                    <span class="sb-brand-tag">
                        {{ $brandEyebrow }}
                    </span>
                @endif
            </span>
        </div>
    @endif

    @if (filled($heading))
        <h1 class="fi-simple-header-heading">
            {{ $heading }}
        </h1>
    @endif

    @if (filled($subheading))
        <p class="fi-simple-header-subheading">
            {{ $subheading }}
        </p>
    @endif
</header>
