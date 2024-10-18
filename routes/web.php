<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageHomeController;
use App\Http\Controllers\PageVideosController;
use App\Http\Controllers\PageDashboardController;
use App\Http\Controllers\PageCourseDetailsController;

Route::get('/', PageHomeController::class)->name('pages.home');

Route::get('courses/{course:slug}', PageCourseDetailsController::class)
->name('pages.course-details');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', PageDashboardController::class)->name('dashboard');
    })->name('dashboard');
    Route::get('videos/{course:slug}', PageVideosController::class)->name('page.course-videos');

