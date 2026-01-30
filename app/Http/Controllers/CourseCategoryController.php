<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $categories = CourseCategory::latest()->get();

        return view('admin.course-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        return view('admin.course-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:course_categories,slug',
        ]);

        CourseCategory::create($validated);

        return redirect()->route('course-categories.index')->with('success', 'Course category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseCategory $courseCategory): \Illuminate\View\View
    {
        return view('admin.course-categories.edit', compact('courseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCategory $courseCategory): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:course_categories,slug,'.$courseCategory->id,
        ]);

        $courseCategory->update($validated);

        return redirect()->route('course-categories.index')->with('success', 'Course category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $courseCategory): \Illuminate\Http\RedirectResponse
    {
        $courseCategory->delete();

        return redirect()->route('course-categories.index')->with('success', 'Course category deleted successfully.');
    }
}
