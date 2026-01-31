<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource (admin).
     */
    public function index(): View
    {
        $pages = Page::withCount('sections')->latest()->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_homepage' => 'boolean',
            'layout' => 'nullable|string|in:public,landing,minimal',
            'is_active' => 'boolean',
        ]);

        $validated['is_homepage'] = $request->boolean('is_homepage');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['layout'] = $validated['layout'] ?? 'public';

        if ($validated['is_homepage']) {
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
        }

        Page::create($validated);

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page): View
    {
        $page->load('sections');

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,'.$page->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_homepage' => 'boolean',
            'layout' => 'nullable|string|in:public,landing,minimal',
            'is_active' => 'boolean',
        ]);

        $validated['is_homepage'] = $request->boolean('is_homepage');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['layout'] = $validated['layout'] ?? 'public';

        DB::transaction(function () use ($page, $validated) {
            if ($validated['is_homepage'] && ! $page->is_homepage) {
                Page::where('is_homepage', true)->update(['is_homepage' => false]);
            }

            $page->update($validated);
        });

        return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page): \Illuminate\Http\RedirectResponse
    {
        $page->delete();

        return redirect()->route('pages.index')->with('success', 'Page deleted successfully.');
    }

    /**
     * Display the homepage (public).
     */
    public function home(): View
    {
        $page = Page::homepage();

        if (! $page) {
            abort(404, 'Homepage not configured.');
        }

        $page->load('activeSections');

        return view('page', compact('page'));
    }

    /**
     * Display a page by slug (public).
     */
    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)->active()->firstOrFail();
        $page->load('activeSections');

        return view('page', compact('page'));
    }
}
