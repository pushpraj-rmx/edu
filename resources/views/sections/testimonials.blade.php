@php
    $heading = $content['heading'] ?? '';
    $displayStyle = $content['display_style'] ?? 'slider';
    $items = $content['items'] ?? [];
    $testimonialId = 'testimonial-' . uniqid();
@endphp

@if (count($items) > 0)
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            @if ($heading)
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 text-center mb-12">
                    {{ $heading }}</h2>
            @endif

            @if ($displayStyle === 'grid')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($items as $item)
                        <div
                            class="bg-white dark:bg-gray-800/80 rounded-xl shadow-md dark:shadow-gray-950/50 p-6 border border-transparent dark:border-gray-700/50">
                            <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mb-4" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400 mb-6 italic">"{{ $item['quote'] ?? '' }}"</p>
                            <div class="flex items-center">
                                @if (!empty($item['author_image']))
                                    <img src="{{ str_starts_with($item['author_image'], 'http://') || str_starts_with($item['author_image'], 'https://') ? $item['author_image'] : Storage::url($item['author_image']) }}"
                                        alt="{{ $item['author_name'] ?? '' }}"
                                        class="w-12 h-12 rounded-full object-cover mr-4">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center mr-4">
                                        <span
                                            class="text-indigo-600 dark:text-indigo-300 font-semibold text-lg">{{ substr($item['author_name'] ?? 'A', 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item['author_name'] ?? '' }}</p>
                                    @if (!empty($item['author_title']))
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item['author_title'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Slider Style -->
                <div class="relative" id="{{ $testimonialId }}">
                    <div class="overflow-hidden">
                        <div class="testimonial-track flex transition-transform duration-500">
                            @foreach ($items as $index => $item)
                                <div class="testimonial-item w-full flex-shrink-0 px-4">
                                    <div
                                        class="bg-white dark:bg-gray-800/80 rounded-xl shadow-md dark:shadow-gray-950/50 p-8 max-w-3xl mx-auto text-center border border-transparent dark:border-gray-700/50">
                                        <svg class="w-12 h-12 text-indigo-600 dark:text-indigo-400 mx-auto mb-6"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                        </svg>
                                        <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 italic">
                                            "{{ $item['quote'] ?? '' }}"</p>
                                        <div class="flex items-center justify-center">
                                            @if (!empty($item['author_image']))
                                                <img src="{{ str_starts_with($item['author_image'], 'http://') || str_starts_with($item['author_image'], 'https://') ? $item['author_image'] : Storage::url($item['author_image']) }}"
                                                    alt="{{ $item['author_name'] ?? '' }}"
                                                    class="w-14 h-14 rounded-full object-cover mr-4">
                                            @else
                                                <div
                                                    class="w-14 h-14 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center mr-4">
                                                    <span
                                                        class="text-indigo-600 dark:text-indigo-300 font-semibold text-xl">{{ substr($item['author_name'] ?? 'A', 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div class="text-left">
                                                <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $item['author_name'] ?? '' }}
                                                </p>
                                                @if (!empty($item['author_title']))
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $item['author_title'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if (count($items) > 1)
                        <div class="flex justify-center mt-8 space-x-2">
                            @foreach ($items as $index => $item)
                                <button
                                    class="testimonial-dot w-3 h-3 rounded-full transition-colors {{ $index === 0 ? 'bg-indigo-600 dark:bg-indigo-500' : 'bg-gray-300 dark:bg-gray-600' }}"
                                    data-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if (count($items) > 1)
                    <script>
                        (function() {
                            const container = document.getElementById('{{ $testimonialId }}');
                            if (!container) return;

                            const track = container.querySelector('.testimonial-track');
                            const dots = container.querySelectorAll('.testimonial-dot');
                            let currentIndex = 0;

                            function showSlide(index) {
                                track.style.transform = `translateX(-${index * 100}%)`;
                                dots.forEach((dot, i) => {
                                    const isActive = i === index;
                                    dot.classList.toggle('bg-indigo-600', isActive);
                                    dot.classList.toggle('bg-gray-300', !isActive);
                                    dot.classList.toggle('dark:bg-indigo-500', isActive);
                                    dot.classList.toggle('dark:bg-gray-600', !isActive);
                                });
                                currentIndex = index;
                            }

                            dots.forEach((dot, index) => {
                                dot.addEventListener('click', () => showSlide(index));
                            });

                            setInterval(() => {
                                showSlide((currentIndex + 1) % {{ count($items) }});
                            }, 5000);
                        })();
                    </script>
                @endif
            @endif
        </div>
    </section>
@endif
