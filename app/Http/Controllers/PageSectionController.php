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

        $sectionType = SectionType::from($validated['type']);

        $maxPosition = $page->sections()->max('position') ?? -1;

        $page->sections()->create([
            'type' => $sectionType->value,
            'content' => array_merge($sectionType->defaultContent(), $validated['content']),
            'position' => $validated['position'] ?? $maxPosition + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('pages.edit', $page)->with('success', 'Section added successfully.');
    }

    /**
     * Show the form for editing a section.
     */
    public function edit(PageSection $section): View
    {
        $page = $section->page;
        $sectionTypes = SectionType::cases();

        return view('admin.page-sections.edit', compact('section', 'page', 'sectionTypes'));
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, PageSection $section): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'position' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $section->update([
            'content' => $validated['content'],
            'position' => $validated['position'] ?? $section->position,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('pages.edit', $section->page)->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified section.
     */
    public function destroy(PageSection $section): RedirectResponse
    {
        $page = $section->page;
        $section->delete();

        return redirect()->route('pages.edit', $page)->with('success', 'Section deleted successfully.');
    }

    /**
     * Update section positions (for reordering).
     */
    public function reorder(Request $request, Page $page): RedirectResponse
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:page_sections,id',
            'sections.*.position' => 'required|integer|min:0',
        ]);

        foreach ($validated['sections'] as $sectionData) {
            PageSection::where('id', $sectionData['id'])
                ->where('page_id', $page->id)
                ->update(['position' => $sectionData['position']]);
        }

        return redirect()->route('pages.edit', $page)->with('success', 'Section order updated.');
    }
}
