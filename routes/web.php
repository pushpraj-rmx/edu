<?php

use App\Http\Controllers\LayoutSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageSectionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

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
    Route::resource('pages.sections', PageSectionController::class)->shallow();
    Route::resource('offerings', \App\Http\Controllers\OfferingController::class);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::get('site-settings/edit', [\App\Http\Controllers\SiteSettingController::class, 'edit'])->name('site-settings.edit');
    Route::patch('site-settings', [\App\Http\Controllers\SiteSettingController::class, 'update'])->name('site-settings.update');
    Route::get('layout-settings/edit', [LayoutSettingController::class, 'edit'])->name('layout-settings.edit');
    Route::patch('layout-settings', [LayoutSettingController::class, 'update'])->name('layout-settings.update');
});

require __DIR__.'/auth.php';
