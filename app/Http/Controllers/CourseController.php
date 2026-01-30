<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\View\View
    {
        $courses = Course::with('category')->latest()->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\View\View
    {
        $categories = CourseCategory::pluck('name', 'id');

        return view('admin.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug',
            'course_category_id' => 'required|exists:course_categories,id',
            'duration' => 'nullable',
            'eligibility' => 'nullable',
            'intake' => 'nullable|integer',
            'description' => 'nullable',
            'syllabus_pdf' => 'nullable',
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): \Illuminate\View\View
    {
        $categories = CourseCategory::pluck('name', 'id');

        return view('admin.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:courses,slug,'.$course->id,
            'course_category_id' => 'required|exists:course_categories,id',
            'duration' => 'nullable',
            'eligibility' => 'nullable',
            'intake' => 'nullable|integer',
            'description' => 'nullable',
            'syllabus_pdf' => 'nullable',
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): \Illuminate\Http\RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
