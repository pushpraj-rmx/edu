@php
    $title = $content['title'] ?? '';
    $subtitle = $content['subtitle'] ?? '';
    $backgroundImage = $content['background_image'] ?? null;
    $overlayOpacity = $content['overlay_opacity'] ?? 50;
    $ctaText = $content['cta_text'] ?? '';
    $ctaUrl = $content['cta_url'] ?? '';
@endphp

<section class="relative min-h-[500px] flex items-center justify-center overflow-hidden">
    @if($backgroundImage)
        <div class="absolute inset-0">
            <img src="{{ Storage::url($backgroundImage) }}" alt="{{ $title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black" style="opacity: {{ $overlayOpacity / 100 }}"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
    @endif

    <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        @if($title)
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                {{ $title }}
            </h1>
        @endif

        @if($subtitle)
            <p class="text-xl sm:text-2xl text-white/90 mb-8">
                {{ $subtitle }}
            </p>
        @endif

        @if($ctaText && $ctaUrl)
            <a href="{{ $ctaUrl }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-100 transition-colors">
                {{ $ctaText }}
                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        @endif
    </div>
</section>
