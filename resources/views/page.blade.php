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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold">{{ $page->title }}</h1>
                </div>
            </div>
        </div>
    @endforelse
@endsection
