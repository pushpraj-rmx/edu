@php
    $image = $content['image'] ?? null;
    $heading = $content['heading'] ?? '';
    $body = $content['body'] ?? '';
    $imagePosition = $content['image_position'] ?? 'right';
    $imageOnLeft = $imagePosition === 'left';
@endphp

<section class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 {{ $image ? 'md:grid-cols-2' : '' }} gap-8 md:gap-12 items-center">
            {{-- Image: first on mobile; on desktop order by image_position --}}
            @if ($image)
                <div class="order-1 {{ $imageOnLeft ? 'md:order-1' : 'md:order-2' }}">
                    @if (str_starts_with($image, 'http'))
                        <img src="{{ $image }}" alt=""
                            class="w-full h-auto rounded-2xl object-cover shadow-lg">
                    @else
                        <img src="{{ Storage::url($image) }}" alt=""
                            class="w-full h-auto rounded-2xl object-cover shadow-lg">
                    @endif
                </div>
            @endif

            {{-- Text content: second on mobile; on desktop order by image_position --}}
            <div class="order-2 {{ $image ? ($imageOnLeft ? 'md:order-2' : 'md:order-1') : '' }}">
                @if ($heading)
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ $heading }}
                    </h2>
                @endif
                @if ($body)
                    <div class="prose prose-lg prose-indigo dark:prose-invert max-w-none">
                        {!! $body !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
