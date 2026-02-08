@extends('layouts.public')

@section('title', ($offering->meta_title ?? $offering->title) . ' - ' . config('app.name'))

@push('meta')
    @if ($offering->meta_description)
        <meta name="description" content="{{ $offering->meta_description }}">
    @endif
@endpush

@section('content')
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                <li><a href="{{ route('home') }}" class="hover:text-gray-900 dark:hover:text-gray-100">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('offerings.public.index') }}" class="hover:text-gray-900 dark:hover:text-gray-100">
                        {{ config('app.site_type') === 'course' ? 'Courses' : 'Services' }}
                    </a></li>
                <li>/</li>
                <li class="text-gray-900 dark:text-gray-100">{{ $offering->title }}</li>
            </ol>
        </nav>

        <article
            class="bg-white dark:bg-gray-800/80 rounded-lg shadow-md dark:shadow-gray-950/50 overflow-hidden border border-transparent dark:border-gray-700/50">
            <div class="p-8">
                <!-- Category Badge -->
                @if ($offering->category)
                    <span
                        class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/40 rounded-full mb-4">
                        {{ $offering->category->name }}
                    </span>
                @endif

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $offering->title }}</h1>

                <!-- Tags -->
                @if ($offering->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach ($offering->tags as $tag)
                            <span
                                class="text-sm text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-700/50 px-3 py-1 rounded-full">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <!-- Details Grid -->
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200/80 dark:border-gray-700/50">
                    @if ($offering->duration)
                        <div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Duration:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $offering->duration }}</p>
                        </div>
                    @endif

                    @if ($offering->eligibility)
                        <div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Eligibility:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $offering->eligibility }}</p>
                        </div>
                    @endif

                    @if ($offering->intake)
                        <div>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Intake:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $offering->intake }}</p>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if ($offering->description)
                    <div class="prose dark:prose-invert max-w-none mb-8">
                        {!! $offering->description !!}
                    </div>
                @endif

                <!-- Brochure Download -->
                @if ($offering->brochure_pdf)
                    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ asset('storage/' . $offering->brochure_pdf) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-md font-medium transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Download Brochure
                        </a>
                    </div>
                @endif

                <!-- Back Link -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('offerings.public.index') }}"
                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                        ← Back to {{ config('app.site_type') === 'course' ? 'Courses' : 'Services' }}
                    </a>
                </div>
            </div>
        </article>
    </div>
@endsection
