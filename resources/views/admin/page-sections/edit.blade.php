@extends('layouts.admin')

@section('page-title', 'Edit ' . $section->type->label() . ' Section')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pages.edit', $page) }}" class="text-indigo-600 hover:text-indigo-800">
            &larr; Back to {{ $page->title }}
        </a>
    </div>

    <form method="POST" action="{{ route('pages.sections.update', [$page, $section]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        {{ $section->type->label() }}
                    </span>
                </div>

                @php $content = $section->content; @endphp

                {{-- Hero Section --}}
                @if ($section->type->value === 'hero')
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="hero_badge" :value="__('Badge (pill above headline)')" />
                            <x-text-input id="hero_badge" name="content[badge]" type="text" class="mt-1 block w-full"
                                :value="old('content.badge', $content['badge'] ?? '')" placeholder="e.g. NEW RELEASE" />
                        </div>
                        <div>
                            <x-input-label for="hero_title" :value="__('Headline Title')" />
                            <x-text-input id="hero_title" name="content[title]" type="text" class="mt-1 block w-full"
                                :value="old('content.title', $content['title'] ?? '')" placeholder="e.g. Grow faster with our platform" />
                        </div>
                        <div>
                            <x-input-label for="hero_highlight_phrase" :value="__('Highlight Phrase (exact text in title that gets gradient)')" />
                            <x-text-input id="hero_highlight_phrase" name="content[highlight_phrase]" type="text"
                                class="mt-1 block w-full" :value="old('content.highlight_phrase', $content['highlight_phrase'] ?? '')" placeholder="e.g. faster" />
                        </div>
                        <div>
                            <x-input-label for="hero_subtitle" :value="__('Subtitle / Supporting Paragraph')" />
                            <textarea id="hero_subtitle" name="content[subtitle]" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content.subtitle', $content['subtitle'] ?? '') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="hero_primary_cta_text" :value="__('Primary CTA Text')" />
                                <x-text-input id="hero_primary_cta_text" name="content[primary_cta_text]" type="text"
                                    class="mt-1 block w-full" :value="old('content.primary_cta_text', $content['primary_cta_text'] ?? '')" placeholder="e.g. Get Started" />
                            </div>
                            <div>
                                <x-input-label for="hero_primary_cta_url" :value="__('Primary CTA URL')" />
                                <x-text-input id="hero_primary_cta_url" name="content[primary_cta_url]" type="text"
                                    class="mt-1 block w-full" :value="old('content.primary_cta_url', $content['primary_cta_url'] ?? '')" placeholder="/signup" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="hero_secondary_cta_text" :value="__('Secondary CTA Text')" />
                                <x-text-input id="hero_secondary_cta_text" name="content[secondary_cta_text]" type="text"
                                    class="mt-1 block w-full" :value="old('content.secondary_cta_text', $content['secondary_cta_text'] ?? '')" placeholder="e.g. Learn More" />
                            </div>
                            <div>
                                <x-input-label for="hero_secondary_cta_url" :value="__('Secondary CTA URL')" />
                                <x-text-input id="hero_secondary_cta_url" name="content[secondary_cta_url]" type="text"
                                    class="mt-1 block w-full" :value="old('content.secondary_cta_url', $content['secondary_cta_url'] ?? '')" placeholder="/features" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="hero_image_file" :value="__('Hero image (right column)')" />
                            <input id="hero_image_file" name="content_image_file" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            @if (!empty($content['image']))
                                <p class="mt-1 text-sm text-gray-500">Current image. Upload a new file to replace.</p>
                                @if (!str_starts_with($content['image'], 'http'))
                                    <img src="{{ Storage::url($content['image']) }}" alt=""
                                        class="mt-2 h-20 w-auto rounded object-cover">
                                @endif
                            @endif
                        </div>
                        <div>
                            <x-input-label for="hero_background_image_file" :value="__('Background image (optional)')" />
                            <input id="hero_background_image_file" name="content_background_image_file" type="file"
                                accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            @if (!empty($content['background_image']))
                                <p class="mt-1 text-sm text-gray-500">Current background. Upload a new file to replace.</p>
                                <img src="{{ Storage::url($content['background_image']) }}" alt=""
                                    class="mt-2 h-20 w-auto rounded object-cover">
                            @endif
                        </div>
                        <div>
                            <x-input-label for="hero_overlay_opacity" :value="__('Overlay opacity (0–100)')" />
                            <x-text-input id="hero_overlay_opacity" name="content[overlay_opacity]" type="number"
                                min="0" max="100" class="mt-1 block w-24" :value="old('content.overlay_opacity', $content['overlay_opacity'] ?? 50)" />
                        </div>
                    </div>
                @endif

                {{-- Stats Strip Section --}}
                @if ($section->type->value === 'stats_strip')
                    @php
                        $statsStripStats = $content['stats'] ?? [];
                        $statsStripStats = array_values(is_array($statsStripStats) ? $statsStripStats : []);
                        while (count($statsStripStats) < 4) {
                            $statsStripStats[] = ['value' => '', 'label' => ''];
                        }
                    @endphp
                    <div class="space-y-4">
                        <div>
                            <x-input-label :value="__('Stats (strip)')" class="mb-2" />
                            <div id="stats-strip-stats-container" class="space-y-3">
                                @foreach ($statsStripStats as $index => $stat)
                                    <div
                                        class="stats-strip-stat-item flex gap-4 items-end border rounded-md p-3 bg-gray-50">
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium text-gray-700">Value
                                                (number/text)
                                            </label>
                                            <input name="content[stats][{{ $index }}][value]" type="text"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                placeholder="e.g. 12"
                                                value="{{ old('content.stats.' . $index . '.value', $stat['value'] ?? '') }}">
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-medium text-gray-700">Label</label>
                                            <input name="content[stats][{{ $index }}][label]" type="text"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                placeholder="e.g. YEARS EXPERIENCE"
                                                value="{{ old('content.stats.' . $index . '.label', $stat['label'] ?? '') }}">
                                        </div>
                                        <button type="button"
                                            class="stat-remove text-red-600 hover:text-red-800 text-sm py-1">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="stats-strip-stat-add"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add stat</button>
                        </div>
                    </div>
                @endif

                {{-- Rich Text Section --}}
                @if ($section->type->value === 'rich_text')
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="rich_heading" :value="__('Heading (optional)')" />
                            <x-text-input id="rich_heading" name="content[heading]" type="text"
                                class="mt-1 block w-full" :value="old('content.heading', $content['heading'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="rich_body" :value="__('Body Content')" />
                            <textarea id="rich_body" name="content[body]" rows="10"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('content.body', $content['body'] ?? '') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">HTML is allowed for formatting.</p>
                        </div>
                    </div>
                @endif

                {{-- Card Grid Section --}}
                @if ($section->type->value === 'card_grid')
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="card_heading" :value="__('Section Heading')" />
                            <x-text-input id="card_heading" name="content[heading]" type="text"
                                class="mt-1 block w-full" :value="old('content.heading', $content['heading'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="card_subheading" :value="__('Subheading')" />
                            <x-text-input id="card_subheading" name="content[subheading]" type="text"
                                class="mt-1 block w-full" :value="old('content.subheading', $content['subheading'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="card_columns" :value="__('Columns')" />
                            <select id="card_columns" name="content[columns]"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="2" {{ ($content['columns'] ?? 3) == 2 ? 'selected' : '' }}>2 Columns
                                </option>
                                <option value="3" {{ ($content['columns'] ?? 3) == 3 ? 'selected' : '' }}>3 Columns
                                </option>
                                <option value="4" {{ ($content['columns'] ?? 3) == 4 ? 'selected' : '' }}>4 Columns
                                </option>
                            </select>
                        </div>
                        <div>
                            <x-input-label :value="__('Cards')" class="mb-2" />
                            <div id="cards-container" class="space-y-4">
                                @foreach ($content['cards'] ?? [] as $index => $card)
                                    <div class="card-item border rounded-md p-4 bg-gray-50">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                                <input name="content[cards][{{ $index }}][title]" type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $card['title'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                                <input name="card_image_file[{{ $index }}]" type="file"
                                                    accept="image/*"
                                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                @if (!empty($card['image']))
                                                    <p class="mt-1 text-sm text-gray-500">Current:</p>
                                                    @if (str_starts_with($card['image'], 'http'))
                                                        <img src="{{ $card['image'] }}" alt=""
                                                            class="mt-1 h-16 w-auto rounded object-cover">
                                                    @else
                                                        <img src="{{ Storage::url($card['image']) }}" alt=""
                                                            class="mt-1 h-16 w-auto rounded object-cover">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="content[cards][{{ $index }}][description]" rows="2"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $card['description'] ?? '' }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Link URL</label>
                                                <input name="content[cards][{{ $index }}][link_url]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $card['link_url'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Link Text</label>
                                                <input name="content[cards][{{ $index }}][link_text]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $card['link_text'] ?? 'Learn More' }}">
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-card"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add Card</button>
                        </div>
                    </div>
                @endif

                {{-- Carousel Section --}}
                @if ($section->type->value === 'carousel')
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="content[autoplay]" value="1"
                                    class="rounded border-gray-300 text-indigo-600"
                                    {{ $content['autoplay'] ?? true ? 'checked' : '' }}>
                                <span class="ml-2 text-sm">Autoplay</span>
                            </label>
                            <div>
                                <x-input-label for="carousel_interval" :value="__('Interval (seconds)')" />
                                <x-text-input id="carousel_interval" name="content[interval]" type="number"
                                    min="1" max="30" class="mt-1 block w-24" :value="old('content.interval', $content['interval'] ?? 5)" />
                            </div>
                        </div>
                        <div>
                            <x-input-label :value="__('Slides')" class="mb-2" />
                            <div id="slides-container" class="space-y-4">
                                @foreach ($content['slides'] ?? [] as $index => $slide)
                                    <div class="slide-item border rounded-md p-4 bg-gray-50">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                                <input name="content[slides][{{ $index }}][title]" type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $slide['title'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                                <input name="slide_image_file[{{ $index }}]" type="file"
                                                    accept="image/*"
                                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                @if (!empty($slide['image']))
                                                    <p class="mt-1 text-sm text-gray-500">Current:</p>
                                                    @if (str_starts_with($slide['image'], 'http'))
                                                        <img src="{{ $slide['image'] }}" alt=""
                                                            class="mt-1 h-16 w-auto rounded object-cover">
                                                    @else
                                                        <img src="{{ Storage::url($slide['image']) }}" alt=""
                                                            class="mt-1 h-16 w-auto rounded object-cover">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                                            <input name="content[slides][{{ $index }}][subtitle]" type="text"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                value="{{ $slide['subtitle'] ?? '' }}">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Link URL</label>
                                                <input name="content[slides][{{ $index }}][link_url]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $slide['link_url'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Link Text</label>
                                                <input name="content[slides][{{ $index }}][link_text]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $slide['link_text'] ?? '' }}">
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-slide"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add Slide</button>
                        </div>
                    </div>
                @endif

                {{-- Testimonials Section --}}
                @if ($section->type->value === 'testimonials')
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="testimonial_heading" :value="__('Section Heading')" />
                            <x-text-input id="testimonial_heading" name="content[heading]" type="text"
                                class="mt-1 block w-full" :value="old('content.heading', $content['heading'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="testimonial_style" :value="__('Display Style')" />
                            <select id="testimonial_style" name="content[display_style]"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="slider"
                                    {{ ($content['display_style'] ?? 'slider') === 'slider' ? 'selected' : '' }}>Slider
                                </option>
                                <option value="grid"
                                    {{ ($content['display_style'] ?? 'slider') === 'grid' ? 'selected' : '' }}>Grid
                                </option>
                            </select>
                        </div>
                        <div>
                            <x-input-label :value="__('Testimonials')" class="mb-2" />
                            <div id="testimonials-container" class="space-y-4">
                                @foreach ($content['items'] ?? [] as $index => $item)
                                    <div class="testimonial-item border rounded-md p-4 bg-gray-50">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Quote</label>
                                            <textarea name="content[items][{{ $index }}][quote]" rows="3"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $item['quote'] ?? '' }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4 mt-2">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Author Name</label>
                                                <input name="content[items][{{ $index }}][author_name]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $item['author_name'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Author Title</label>
                                                <input name="content[items][{{ $index }}][author_title]"
                                                    type="text"
                                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    value="{{ $item['author_title'] ?? '' }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Author Image</label>
                                                <input name="author_image_file[{{ $index }}]" type="file"
                                                    accept="image/*"
                                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                                @if (!empty($item['author_image']))
                                                    <p class="mt-1 text-sm text-gray-500">Current:</p>
                                                    @if (str_starts_with($item['author_image'], 'http'))
                                                        <img src="{{ $item['author_image'] }}" alt=""
                                                            class="mt-1 h-12 w-12 rounded-full object-cover">
                                                    @else
                                                        <img src="{{ Storage::url($item['author_image']) }}"
                                                            alt=""
                                                            class="mt-1 h-12 w-12 rounded-full object-cover">
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <button type="button"
                                            class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-testimonial"
                                class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add Testimonial</button>
                        </div>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t">
                    <div class="flex items-center gap-4">
                        <div>
                            <x-input-label for="position" :value="__('Position')" />
                            <x-text-input id="position" name="position" type="number" min="0"
                                class="mt-1 block w-24" :value="old('position', $section->position)" />
                        </div>
                        <label class="flex items-center mt-6">
                            <input type="checkbox" name="is_active" value="1"
                                class="rounded border-gray-300 text-indigo-600"
                                {{ $section->is_active ? 'checked' : '' }}>
                            <span class="ml-2 text-sm">Active</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-4 mt-6">
                    <x-primary-button>{{ __('Update Section') }}</x-primary-button>
                    <a href="{{ route('pages.edit', $page) }}" class="text-gray-600 hover:text-gray-900">Cancel</a>
                </div>
            </div>
        </div>
    </form>

    <script>
        // Card management
        let cardIndex = {{ count($content['cards'] ?? []) }};
        document.getElementById('add-card')?.addEventListener('click', function() {
            const container = document.getElementById('cards-container');
            const template = `
                <div class="card-item border rounded-md p-4 bg-gray-50">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input name="content[cards][${cardIndex}][title]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input name="card_image_file[${cardIndex}]" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="content[cards][${cardIndex}][description]" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link URL</label>
                            <input name="content[cards][${cardIndex}][link_url]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link Text</label>
                            <input name="content[cards][${cardIndex}][link_text]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="Learn More">
                        </div>
                    </div>
                    <button type="button" class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            cardIndex++;
        });

        // Slide management
        let slideIndex = {{ count($content['slides'] ?? []) }};
        document.getElementById('add-slide')?.addEventListener('click', function() {
            const container = document.getElementById('slides-container');
            const template = `
                <div class="slide-item border rounded-md p-4 bg-gray-50">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input name="content[slides][${slideIndex}][title]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input name="slide_image_file[${slideIndex}]" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <input name="content[slides][${slideIndex}][subtitle]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link URL</label>
                            <input name="content[slides][${slideIndex}][link_url]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link Text</label>
                            <input name="content[slides][${slideIndex}][link_text]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                    </div>
                    <button type="button" class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            slideIndex++;
        });

        // Testimonial management
        let testimonialIndex = {{ count($content['items'] ?? []) }};
        document.getElementById('add-testimonial')?.addEventListener('click', function() {
            const container = document.getElementById('testimonials-container');
            const template = `
                <div class="testimonial-item border rounded-md p-4 bg-gray-50">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quote</label>
                        <textarea name="content[items][${testimonialIndex}][quote]" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Author Name</label>
                            <input name="content[items][${testimonialIndex}][author_name]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Author Title</label>
                            <input name="content[items][${testimonialIndex}][author_title]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Author Image</label>
                            <input name="author_image_file[${testimonialIndex}]" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                    <button type="button" class="remove-item mt-2 text-sm text-red-600 hover:text-red-800">Remove</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            testimonialIndex++;
        });

        // Stats strip: add row
        let statsStripIndex = {{ $section->type->value === 'stats_strip' ? count($content['stats'] ?? []) : 0 }};
        document.getElementById('stats-strip-stat-add')?.addEventListener('click', function() {
            const container = document.getElementById('stats-strip-stats-container');
            if (!container) return;
            const template = `
                <div class="stats-strip-stat-item flex gap-4 items-end border rounded-md p-3 bg-gray-50">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Value (number/text)</label>
                        <input name="content[stats][${statsStripIndex}][value]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="e.g. 12">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700">Label</label>
                        <input name="content[stats][${statsStripIndex}][label]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="e.g. YEARS EXPERIENCE">
                    </div>
                    <button type="button" class="stat-remove text-red-600 hover:text-red-800 text-sm py-1">Remove</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            statsStripIndex++;
        });

        // Remove item handler
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.closest('.card-item, .slide-item, .testimonial-item').remove();
            }
            if (e.target.classList.contains('stat-remove')) {
                e.target.closest('.stats-strip-stat-item')?.remove();
            }
        });
    </script>
@endsection
