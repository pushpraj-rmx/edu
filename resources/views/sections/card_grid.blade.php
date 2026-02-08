@php
    $heading = $content['heading'] ?? '';
    $subheading = $content['subheading'] ?? '';
    $columns = $content['columns'] ?? 3;
    $cards = $content['cards'] ?? [];

    $gridCols = match ($columns) {
        2 => 'md:grid-cols-2',
        4 => 'md:grid-cols-2 lg:grid-cols-4',
        default => 'md:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        @if ($heading || $subheading)
            <div class="text-center mb-12">
                @if ($heading)
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $heading }}
                    </h2>
                @endif
                @if ($subheading)
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">{{ $subheading }}</p>
                @endif
            </div>
        @endif

        @if (count($cards) > 0)
            <div class="grid grid-cols-1 {{ $gridCols }} gap-8">
                @foreach ($cards as $card)
                    <div
                        class="bg-white dark:bg-gray-800/80 rounded-xl shadow-md dark:shadow-gray-950/50 overflow-hidden hover:shadow-lg dark:hover:shadow-gray-950/60 transition-shadow border border-transparent dark:border-gray-700/50">
                        @if (!empty($card['image']))
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ str_starts_with($card['image'], 'http://') || str_starts_with($card['image'], 'https://') ? $card['image'] : Storage::url($card['image']) }}"
                                    alt="{{ $card['title'] ?? '' }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="p-6">
                            @if (!empty($card['title']))
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $card['title'] }}</h3>
                            @endif
                            @if (!empty($card['description']))
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $card['description'] }}</p>
                            @endif
                            @if (!empty($card['link_url']))
                                <a href="{{ $card['link_url'] }}"
                                    class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                                    {{ $card['link_text'] ?? 'Learn More' }}
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
