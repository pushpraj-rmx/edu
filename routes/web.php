<?php

use App\Http\Controllers\LayoutSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageSectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/offerings', [\App\Http\Controllers\OfferingController::class, 'publicIndex'])->name('offerings.public.index');
Route::get('/offerings/{slug}', [\App\Http\Controllers\OfferingController::class, 'publicShow'])->name('offerings.public.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');
    Route::resource('pages', PageController::class);
    Route::get('pages/{page}/sections/create', [PageSectionController::class, 'create'])->name('pages.sections.create');
    Route::post('pages/{page}/sections', [PageSectionController::class, 'store'])->name('pages.sections.store');
    Route::get('pages/{page}/sections/{section}/edit', [PageSectionController::class, 'edit'])->name('pages.sections.edit');
    Route::put('pages/{page}/sections/{section}', [PageSectionController::class, 'update'])->name('pages.sections.update');
    Route::delete('pages/{page}/sections/{section}', [PageSectionController::class, 'destroy'])->name('pages.sections.destroy');
    Route::patch('pages/{page}/sections/{section}/toggle', [PageSectionController::class, 'toggle'])->name('pages.sections.toggle');
    Route::post('pages/{page}/sections/{section}/move-up', [PageSectionController::class, 'moveUp'])->name('pages.sections.move-up');
    Route::post('pages/{page}/sections/{section}/move-down', [PageSectionController::class, 'moveDown'])->name('pages.sections.move-down');
    Route::resource('offerings', \App\Http\Controllers\OfferingController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::get('layout-settings/edit', [LayoutSettingController::class, 'edit'])->name('layout-settings.edit');
    Route::patch('layout-settings', [LayoutSettingController::class, 'update'])->name('layout-settings.update');
});

require __DIR__.'/auth.php';

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
