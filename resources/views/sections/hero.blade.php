@php
    use Illuminate\Support\Str;

    $badge = $content['badge'] ?? '';
    $title = $content['title'] ?? '';
    $highlightPhrase = $content['highlight_phrase'] ?? '';
    $subtitle = $content['subtitle'] ?? '';
    $primaryCtaText = $content['primary_cta_text'] ?? ($content['cta_text'] ?? '');
    $primaryCtaUrl = $content['primary_cta_url'] ?? ($content['cta_url'] ?? '');
    $secondaryCtaText = $content['secondary_cta_text'] ?? '';
    $secondaryCtaUrl = $content['secondary_cta_url'] ?? '';
    $image = $content['image'] ?? null;
    $imageUrl =
        $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'))
            ? $image
            : ($image
                ? \Illuminate\Support\Facades\Storage::url($image)
                : null);
    $backgroundImage = $content['background_image'] ?? null;
    $backgroundUrl =
        $backgroundImage &&
        (str_starts_with($backgroundImage, 'http://') || str_starts_with($backgroundImage, 'https://'))
            ? $backgroundImage
            : ($backgroundImage
                ? \Illuminate\Support\Facades\Storage::url($backgroundImage)
                : null);
    $overlayOpacity = max(0, min(100, (int) ($content['overlay_opacity'] ?? 50)));

    $titleBefore = $title;
    $titlePhrase = '';
    $titleAfter = '';
    if ($highlightPhrase !== '' && $title !== '' && Str::contains($title, $highlightPhrase)) {
        $titleBefore = Str::before($title, $highlightPhrase);
        $titlePhrase = $highlightPhrase;
        $titleAfter = Str::after($title, $highlightPhrase);
    }
@endphp

<section class="relative pt-24 sm:pt-28 lg:pt-32 pb-0 {{ $backgroundUrl ? '' : 'bg-gray-50 dark:bg-gray-900' }}">
    @if ($backgroundUrl)
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ $backgroundUrl }}');" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-white dark:bg-gray-950" style="opacity: {{ $overlayOpacity / 100 }};"
            aria-hidden="true"></div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {{-- Left column --}}
            <div class="order-2 lg:order-1">
                @if ($badge !== '')
                    <span
                        class="inline-block px-4 py-1.5 rounded-full text-xs font-medium tracking-wide text-indigo-700 bg-indigo-50 dark:text-indigo-300 dark:bg-indigo-900/40 mb-6">
                        {{ $badge }}
                    </span>
                @endif

                @if ($title !== '')
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-gray-100 leading-tight mb-6">
                        @if ($titlePhrase !== '')
                            {{ $titleBefore }}<span
                                class="bg-linear-to-r from-indigo-500 to-purple-600 dark:from-indigo-400 dark:to-purple-500 bg-clip-text text-transparent">{{ $titlePhrase }}</span>{{ $titleAfter }}
                        @else
                            {{ $title }}
                        @endif
                    </h1>
                @endif

                @if ($subtitle !== '')
                    <p class="max-w-xl text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                        {{ $subtitle }}
                    </p>
                @endif

                @if ($primaryCtaText !== '' || $secondaryCtaText !== '')
                    <div class="flex flex-wrap items-center gap-4">
                        @if ($primaryCtaText !== '' && $primaryCtaUrl !== '')
                            <a href="{{ $primaryCtaUrl }}"
                                class="inline-flex items-center gap-2 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-3 text-base font-medium hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                {{ $primaryCtaText }}
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        @endif
                        @if ($secondaryCtaText !== '' && $secondaryCtaUrl !== '')
                            <a href="{{ $secondaryCtaUrl }}"
                                class="text-gray-900 dark:text-gray-200 font-medium underline-offset-4 hover:underline focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500 rounded">
                                {{ $secondaryCtaText }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Right column: image with decorative shape --}}
            <div class="order-1 lg:order-2 relative pl-0 lg:pl-8">
                @if ($imageUrl)
                    <div class="relative">
                        <div class="absolute -top-4 -right-4 w-64 h-64 sm:w-80 sm:h-80 rounded-full bg-indigo-100/60 dark:bg-indigo-900/30 blur-2xl -z-10"
                            aria-hidden="true"></div>
                        <div class="absolute -bottom-8 -left-8 w-48 h-48 rounded-full bg-purple-100/50 dark:bg-purple-900/20 blur-2xl -z-10"
                            aria-hidden="true"></div>
                        <img src="{{ $imageUrl }}" alt="{{ $title }}"
                            class="relative w-full max-w-lg mx-auto rounded-2xl shadow-lg dark:shadow-gray-950/50 object-cover">
                    </div>
                @else
                    <div
                        class="relative w-full max-w-lg mx-auto aspect-square rounded-2xl bg-white/80 dark:bg-gray-800/80 border border-gray-200/80 dark:border-gray-700/80 flex items-center justify-center">
                        <div class="absolute inset-0 rounded-2xl bg-indigo-100/40 dark:bg-indigo-900/20 blur-2xl -z-10"
                            aria-hidden="true">
                        </div>
                        <span class="text-gray-400 dark:text-gray-500 text-sm">Hero image</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
