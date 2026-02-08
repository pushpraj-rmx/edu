@php
    $stats = $content['stats'] ?? [];
    $stats = is_array($stats) ? array_values($stats) : [];

    $statsWithContent = array_values(array_filter($stats, fn($s) => !empty($s['value'] ?? ($s['label'] ?? null))));
    $statsWithContent = array_slice($statsWithContent, 0, 4);
@endphp

@if (count($statsWithContent) > 0)
    <section class="bg-gray-50 dark:bg-gray-900 pt-16 sm:pt-20 pb-16 sm:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="rounded-2xl bg-white/80 dark:bg-gray-800/80 border border-gray-200/80 dark:border-gray-700/80 shadow-sm dark:shadow-gray-950/50 overflow-hidden">
                <div
                    class="grid grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-gray-200/80 dark:divide-gray-700/80">
                    @foreach ($statsWithContent as $stat)
                        <div class="px-6 py-8 sm:py-10 text-center">
                            <div class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $stat['value'] ?? '' }}
                            </div>
                            <div
                                class="mt-1 text-xs font-medium tracking-wide text-gray-500 dark:text-gray-400 uppercase">
                                {{ $stat['label'] ?? '' }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
