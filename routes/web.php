<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/page/{slug}', function ($slug) {
    $page = \App\Models\Page::where('slug', $slug)->firstOrFail();

    return view('page', compact('page'));
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('pages', \App\Http\Controllers\PageController::class);
    Route::resource('course-categories', \App\Http\Controllers\CourseCategoryController::class);
    Route::resource('courses', \App\Http\Controllers\CourseController::class);
});

require __DIR__.'/auth.php';
