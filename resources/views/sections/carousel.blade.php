@php
    $autoplay = $content['autoplay'] ?? true;
    $interval = ($content['interval'] ?? 5) * 1000;
    $slides = $content['slides'] ?? [];
    $carouselId = 'carousel-' . uniqid();
@endphp

@if (count($slides) > 0)
    <section class="relative overflow-hidden" id="{{ $carouselId }}">
        <div class="carousel-container relative">
            @foreach ($slides as $index => $slide)
                <div class="carousel-slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                    data-index="{{ $index }}">
                    <div class="relative min-h-[500px] flex items-center justify-center">
                        @if (!empty($slide['image']))
                            <div class="absolute inset-0">
                                <img src="{{ str_starts_with($slide['image'], 'http://') || str_starts_with($slide['image'], 'https://') ? $slide['image'] : Storage::url($slide['image']) }}"
                                    alt="{{ $slide['title'] ?? '' }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40"></div>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
                        @endif

                        <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
                            @if (!empty($slide['title']))
                                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-4">{{ $slide['title'] }}</h2>
                            @endif
                            @if (!empty($slide['subtitle']))
                                <p class="text-xl text-white/90 mb-6">{{ $slide['subtitle'] }}</p>
                            @endif
                            @if (!empty($slide['link_url']) && !empty($slide['link_text']))
                                <a href="{{ $slide['link_url'] }}"
                                    class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-medium rounded-md hover:bg-gray-100 transition-colors">
                                    {{ $slide['link_text'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (count($slides) > 1)
            <!-- Navigation Arrows -->
            <button
                class="carousel-prev absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/80 hover:bg-white text-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button
                class="carousel-next absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/80 hover:bg-white text-gray-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex space-x-2">
                @foreach ($slides as $index => $slide)
                    <button
                        class="carousel-dot w-3 h-3 rounded-full transition-colors {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                        data-index="{{ $index }}"></button>
                @endforeach
            </div>
        @endif
    </section>

    <script>
        (function() {
            const carousel = document.getElementById('{{ $carouselId }}');
            if (!carousel) return;

            const slides = carousel.querySelectorAll('.carousel-slide');
            const dots = carousel.querySelectorAll('.carousel-dot');
            const prevBtn = carousel.querySelector('.carousel-prev');
            const nextBtn = carousel.querySelector('.carousel-next');
            let currentIndex = 0;
            let autoplayInterval;

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('opacity-100', i === index);
                    slide.classList.toggle('opacity-0', i !== index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('bg-white', i === index);
                    dot.classList.toggle('bg-white/50', i !== index);
                });
                currentIndex = index;
            }

            function nextSlide() {
                showSlide((currentIndex + 1) % slides.length);
            }

            function prevSlide() {
                showSlide((currentIndex - 1 + slides.length) % slides.length);
            }

            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => showSlide(index));
            });

            @if ($autoplay)
                autoplayInterval = setInterval(nextSlide, {{ $interval }});
                carousel.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
                carousel.addEventListener('mouseleave', () => {
                    autoplayInterval = setInterval(nextSlide, {{ $interval }});
                });
            @endif
        })();
    </script>
@endif
