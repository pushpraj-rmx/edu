@extends('layouts.public')

@section('title', (config('app.site_type') === 'course' ? 'Our Courses' : 'Our Services') . ' - ' . config('app.name'))

@section('content')
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            @if(config('app.site_type') == 'course')
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Our Courses</h1>
            @else
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Our Services</h1>
            @endif
            <p class="text-lg text-gray-600">
                {{ config('app.site_type') === 'course' ? 'Explore our comprehensive range of educational programs' : 'Discover our professional digital solutions' }}
            </p>
        </div>

        @if($offerings->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600 text-lg">
                    {{ config('app.site_type') === 'course' ? 'No courses available at the moment.' : 'No services available at the moment.' }}
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($offerings as $offering)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            @if($offering->category)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-3">
                                    {{ $offering->category->name }}
                                </span>
                            @endif

                            <h2 class="text-xl font-semibold text-gray-900 mb-3">
                                {{ $offering->title }}
                            </h2>

                            @if($offering->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit(strip_tags($offering->description), 120) }}
                                </p>
                            @endif

                            @if($offering->tags->isNotEmpty())
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($offering->tags->take(3) as $tag)
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <a href="{{ route('offerings.public.show', $offering->slug) }}" 
                               class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
