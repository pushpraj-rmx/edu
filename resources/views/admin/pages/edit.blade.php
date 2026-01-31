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

        {{-- Page Sections --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Page Sections</h2>
                    <a href="{{ route('pages.sections.create', $page) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 px-4 rounded">
                        Add Section
                    </a>
                </div>

                @if($page->sections->count() > 0)
                    <div class="space-y-3">
                        @foreach($page->sections->sortBy('position') as $section)
                            <div class="flex items-center justify-between border rounded-lg p-4 {{ $section->is_active ? 'bg-white' : 'bg-gray-50' }}">
                                <div class="flex items-center gap-4">
                                    <span class="text-gray-400 text-sm w-8">{{ $section->position }}</span>
                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $section->type->label() }}
                                        </span>
                                        @if(!$section->is_active)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                                Hidden
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-600">
                                        @switch($section->type->value)
                                            @case('hero')
                                                {{ $section->content['title'] ?? 'Untitled Hero' }}
                                                @break
                                            @case('rich_text')
                                                {{ $section->content['heading'] ?? Str::limit(strip_tags($section->content['body'] ?? ''), 50) }}
                                                @break
                                            @case('card_grid')
                                                {{ $section->content['heading'] ?? 'Card Grid' }} ({{ count($section->content['cards'] ?? []) }} cards)
                                                @break
                                            @case('carousel')
                                                Carousel ({{ count($section->content['slides'] ?? []) }} slides)
                                                @break
                                            @case('testimonials')
                                                {{ $section->content['heading'] ?? 'Testimonials' }} ({{ count($section->content['items'] ?? []) }} items)
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('sections.edit', $section) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <form action="{{ route('sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this section?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No sections yet. Add your first section to build this page.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
