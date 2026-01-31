<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Offering;
use App\Models\Tag;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $offerings = Offering::with('category')->latest()->get();

        return view('admin.offerings.index', compact('offerings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        return view('admin.offerings.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:offerings,slug',
            'type' => 'required|in:course,service',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'nullable',
            'eligibility' => 'nullable',
            'intake' => 'nullable|integer',
            'description' => 'nullable',
            'brochure_pdf' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'tags' => 'nullable|array',
        ]);

        $offering = Offering::create($validated);

        if ($request->has('tags')) {
            $offering->tags()->sync($request->tags);
        }

        return redirect()->route('offerings.index')->with('success', 'Offering created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offering $offering): \Illuminate\View\View
    {
        $categories = Category::where('type', $offering->type)->pluck('name', 'id');
        $tags = Tag::where('type', $offering->type)->pluck('name', 'id');

        return view('admin.offerings.edit', compact('offering', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offering $offering): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:offerings,slug,'.$offering->id,
            'type' => 'required|in:course,service',
            'category_id' => 'required|exists:categories,id',
            'duration' => 'nullable',
            'eligibility' => 'nullable',
            'intake' => 'nullable|integer',
            'description' => 'nullable',
            'brochure_pdf' => 'nullable',
            'meta_title' => 'nullable',
            'meta_description' => 'nullable',
            'tags' => 'nullable|array',
        ]);

        $offering->update($validated);

        if ($request->has('tags')) {
            $offering->tags()->sync($request->tags);
        } else {
            $offering->tags()->sync([]);
        }

        return redirect()->route('offerings.index')->with('success', 'Offering updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offering $offering): \Illuminate\Http\RedirectResponse
    {
        $offering->delete();

        return redirect()->route('offerings.index')->with('success', 'Offering deleted successfully.');
    }

    /**
     * Display a listing of offerings for public view.
     */
    public function publicIndex(): \Illuminate\View\View
    {
        $siteType = config('app.site_type', 'course');
        $offerings = Offering::where('type', $siteType)
            ->with(['category', 'tags'])
            ->latest()
            ->get();

        return view('offerings.index', compact('offerings'));
    }

    /**
     * Display the specified offering for public view.
     */
    public function publicShow(string $slug): \Illuminate\View\View
    {
        $siteType = config('app.site_type', 'course');
        $offering = Offering::where('slug', $slug)
            ->where('type', $siteType)
            ->with(['category', 'tags'])
            ->firstOrFail();

        return view('offerings.show', compact('offering'));
    }
}
