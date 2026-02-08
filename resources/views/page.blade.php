@extends('layouts.public')

@section('title', $page->meta_title ?? $page->title)

@push('meta')
    @if ($page->meta_description)
        <meta name="description" content="{{ $page->meta_description }}">
    @endif
    <meta property="og:title" content="{{ $page->meta_title ?? $page->title }}">
    @if ($page->meta_description)
        <meta property="og:description" content="{{ $page->meta_description }}">
    @endif
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@section('content')
    @forelse($page->activeSections as $section)
        @include('sections.' . $section->type->value, ['content' => $section->content])
    @empty
        {{-- No sections - show page title as fallback --}}
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800/80 overflow-hidden shadow-sm dark:shadow-gray-950/50 sm:rounded-lg border border-transparent dark:border-gray-700/50">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold">{{ $page->title }}</h1>
                </div>
            </div>
        </div>
    @endforelse
@endsection
