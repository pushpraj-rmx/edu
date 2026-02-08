@php
    $heading = $content['heading'] ?? null;
    $body = $content['body'] ?? '';
@endphp

<section class="py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        @if ($heading)
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-8">{{ $heading }}</h2>
        @endif

        @if ($body)
            <div class="prose prose-lg prose-indigo dark:prose-invert max-w-none">
                {!! $body !!}
            </div>
        @endif
    </div>
</section>
