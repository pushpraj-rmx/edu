@extends('layouts.admin')

@section('page-title', 'Edit Page: ' . $page->title)

@section('content')
    <div class="space-y-6">
        {{-- Page Settings --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-lg font-semibold mb-4">Page Settings</h2>
                <form method="POST" action="{{ route('pages.update', $page) }}">
                    @csrf
                    @method('PUT')
                    @include('admin.pages.form', ['page' => $page])
                </form>
            </div>
        </div>

        {{-- Page Sections (ordered by position) --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Page Sections</h2>
                    <a href="{{ route('pages.sections.create', $page) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded">
                        Add Section
                    </a>
                </div>

                <p class="text-sm text-gray-500 mb-4">Sections are shown in display order. Use Up/Down to reorder.</p>

                <div class="space-y-3">
                    @foreach ($page->sections as $section)
                        <div
                            class="flex items-center justify-between border rounded-lg p-4 {{ $section->is_active ? 'bg-white' : 'bg-gray-50' }}">
                            <div class="flex items-center gap-4">
                                <span class="text-gray-400 text-sm w-8">{{ $section->position }}</span>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('pages.sections.move-up', [$page, $section]) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-500 hover:text-gray-700 p-1"
                                            title="Move up">&uarr;</button>
                                    </form>
                                    <form action="{{ route('pages.sections.move-down', [$page, $section]) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-500 hover:text-gray-700 p-1"
                                            title="Move down">&darr;</button>
                                    </form>
                                </div>
                                <div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $section->type->label() }}
                                    </span>
                                    @if (!$section->is_active)
                                        <span
                                            class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            Hidden
                                        </span>
                                    @endif
                                </div>
                                <span class="text-sm text-gray-600">
                                    @switch($section->type->value)
                                        @case('hero')
                                            {{ $section->content['title'] ?? 'Untitled Hero' }}
                                        @break

                                        @case('stats_strip')
                                            Stats Strip ({{ count($section->content['stats'] ?? []) }} stats)
                                        @break

                                        @case('rich_text')
                                            {{ $section->content['heading'] ?? Str::limit(strip_tags($section->content['body'] ?? ''), 50) }}
                                        @break

                                        @case('card_grid')
                                            {{ $section->content['heading'] ?? 'Card Grid' }}
                                            ({{ count($section->content['cards'] ?? []) }} cards)
                                        @break

                                        @case('carousel')
                                            Carousel ({{ count($section->content['slides'] ?? []) }} slides)
                                        @break

                                        @case('testimonials')
                                            {{ $section->content['heading'] ?? 'Testimonials' }}
                                            ({{ count($section->content['items'] ?? []) }} items)
                                        @break

                                        @default
                                            —
                                    @endswitch
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <form action="{{ route('pages.sections.toggle', [$page, $section]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-600 hover:text-gray-900 text-sm">
                                        {{ $section->is_active ? 'Hide' : 'Show' }}
                                    </button>
                                </form>
                                <a href="{{ route('pages.sections.edit', [$page, $section]) }}"
                                    class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                <form action="{{ route('pages.sections.destroy', [$page, $section]) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this section?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
