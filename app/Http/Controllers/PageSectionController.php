<?php

namespace App\Http\Controllers;

use App\Enums\SectionType;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageSectionController extends Controller
{
    /**
     * Ensure the section belongs to the given page (for route security).
     */
    private function ensureSectionBelongsToPage(Page $page, PageSection $section): void
    {
        if ($section->page_id !== $page->id) {
            abort(404);
        }
    }

    /**
     * Merge uploaded section media into content array.
     *
     * @param  array<string, mixed>  $content
     * @return array<string, mixed>
     */
    private function mergeSectionUploads(Request $request, string $type, array $content): array
    {
        if ($type === 'hero') {
            if ($request->hasFile('content_image_file')) {
                $content['image'] = $request->file('content_image_file')->store('hero', 'public');
            }
            if ($request->hasFile('content_background_image_file')) {
                $content['background_image'] = $request->file('content_background_image_file')->store('hero', 'public');
            }
            if (array_key_exists('overlay_opacity', $content)) {
                $content['overlay_opacity'] = max(0, min(100, (int) ($content['overlay_opacity'] ?? 50)));
            }
        }

        if ($type === 'card_grid' && is_array($content['cards'] ?? null)) {
            $cards = array_values($content['cards']);
            foreach ($request->file('card_image_file', []) as $index => $file) {
                if (isset($cards[$index]) && $file->isValid()) {
                    $cards[$index]['image'] = $file->store('cards', 'public');
                }
            }
            $content['cards'] = $cards;
        }

        if ($type === 'carousel' && is_array($content['slides'] ?? null)) {
            $slides = array_values($content['slides']);
            foreach ($request->file('slide_image_file', []) as $index => $file) {
                if (isset($slides[$index]) && $file->isValid()) {
                    $slides[$index]['image'] = $file->store('carousel', 'public');
                }
            }
            $content['slides'] = $slides;
        }

        if ($type === 'testimonials' && is_array($content['items'] ?? null)) {
            $items = array_values($content['items']);
            foreach ($request->file('author_image_file', []) as $index => $file) {
                if (isset($items[$index]) && $file->isValid()) {
                    $items[$index]['author_image'] = $file->store('testimonials', 'public');
                }
            }
            $content['items'] = $items;
        }

        if ($type === 'image_text' && $request->hasFile('content_image_file')) {
            $content['image'] = $request->file('content_image_file')->store('image_text', 'public');
        }

        return $content;
    }

    /**
     * Show the form for creating a new section.
     */
    public function create(Page $page): View
    {
        $sectionTypes = SectionType::cases();

        return view('admin.page-sections.create', compact('page', 'sectionTypes'));
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:'.implode(',', array_column(SectionType::cases(), 'value')),
            'content' => 'required|array',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        $type = $validated['type'];
        if ($type === 'hero') {
            if ($request->hasFile('content_image_file')) {
                $request->validate(['content_image_file' => 'image|max:2048']);
            }
            if ($request->hasFile('content_background_image_file')) {
                $request->validate(['content_background_image_file' => 'image|max:2048']);
            }
        }
        if ($type === 'image_text' && $request->hasFile('content_image_file')) {
            $request->validate(['content_image_file' => 'image|max:2048']);
        }
        foreach (array_keys($request->file('card_image_file', []) ?: []) as $key) {
            $request->validate(["card_image_file.{$key}" => 'image|max:2048']);
        }
        foreach (array_keys($request->file('slide_image_file', []) ?: []) as $key) {
            $request->validate(["slide_image_file.{$key}" => 'image|max:2048']);
        }
        foreach (array_keys($request->file('author_image_file', []) ?: []) as $key) {
            $request->validate(["author_image_file.{$key}" => 'image|max:2048']);
        }

        $sectionType = SectionType::from($type);
        $content = array_merge($sectionType->defaultContent(), $validated['content']);
        $content = $this->mergeSectionUploads($request, $type, $content);

        $maxPosition = $page->sections()->max('position') ?? -1;

        $page->sections()->create([
            'type' => $sectionType->value,
            'content' => $content,
            'position' => $validated['position'] ?? $maxPosition + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('pages.edit', $page)->with('success', 'Section added successfully.');
    }

    /**
     * Show the form for editing the section.
     */
    public function edit(Page $page, PageSection $section): View
    {
        $this->ensureSectionBelongsToPage($page, $section);
        $sectionTypes = SectionType::cases();

        return view('admin.page-sections.edit', compact('section', 'page', 'sectionTypes'));
    }

    /**
     * Update the section.
     */
    public function update(Request $request, Page $page, PageSection $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section);

        $rules = [
            'content' => 'required|array',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
        if ($section->type === SectionType::Hero) {
            if ($request->hasFile('content_image_file')) {
                $rules['content_image_file'] = 'image|max:2048';
            }
            if ($request->hasFile('content_background_image_file')) {
                $rules['content_background_image_file'] = 'image|max:2048';
            }
        }
        if ($section->type === SectionType::ImageText && $request->hasFile('content_image_file')) {
            $rules['content_image_file'] = 'image|max:2048';
        }
        foreach (array_keys($request->file('card_image_file', []) ?: []) as $key) {
            $rules["card_image_file.{$key}"] = 'image|max:2048';
        }
        foreach (array_keys($request->file('slide_image_file', []) ?: []) as $key) {
            $rules["slide_image_file.{$key}"] = 'image|max:2048';
        }
        foreach (array_keys($request->file('author_image_file', []) ?: []) as $key) {
            $rules["author_image_file.{$key}"] = 'image|max:2048';
        }
        $validated = $request->validate($rules);

        $content = array_merge($section->content, $validated['content']);
        $content = $this->mergeSectionUploads($request, $section->type->value, $content);

        $section->update([
            'content' => $content,
            'position' => $validated['position'] ?? $section->position,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('pages.edit', $page)->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the section.
     */
    public function destroy(Page $page, PageSection $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section);
        $section->delete();

        return redirect()->route('pages.edit', $page)->with('success', 'Section deleted successfully.');
    }

    /**
     * Toggle section visibility (is_active).
     */
    public function toggle(Page $page, PageSection $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section);
        $section->update(['is_active' => ! $section->is_active]);

        return redirect()->route('pages.edit', $page)->with('success', 'Section visibility updated.');
    }

    /**
     * Move section up (swap position with previous section).
     */
    public function moveUp(Page $page, PageSection $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section);
        $previous = $page->sections()->where('position', '<', $section->position)->orderByDesc('position')->first();
        if ($previous) {
            $sectionPos = $section->position;
            $section->update(['position' => $previous->position]);
            $previous->update(['position' => $sectionPos]);
        }

        return redirect()->route('pages.edit', $page)->with('success', 'Section order updated.');
    }

    /**
     * Move section down (swap position with next section).
     */
    public function moveDown(Page $page, PageSection $section): RedirectResponse
    {
        $this->ensureSectionBelongsToPage($page, $section);
        $next = $page->sections()->where('position', '>', $section->position)->orderBy('position')->first();
        if ($next) {
            $sectionPos = $section->position;
            $section->update(['position' => $next->position]);
            $next->update(['position' => $sectionPos]);
        }

        return redirect()->route('pages.edit', $page)->with('success', 'Section order updated.');
    }
}
