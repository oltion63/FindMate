<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CvController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('profile', function () {
    return Inertia::render('profile/profile');
})->middleware(['auth', 'verified'])->name('profile');

Route::middleware('auth')->controller(CvController::class)->group(function () {
    Route::post('/storeCV', 'storeCv')->name('storeCV');
    Route::post('/updateCV',  'updateCV')->name('updateCV');
    Route::delete('/deleteCV/{cv}',  'deleteCV')->name('deleteCV');
});

Route::middleware('admin')->prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard','index')->name('dashboard');
    Route::delete('/user/{user}/delete', 'deleteUser')->name('user.delete');
    Route::delete('/post/{post}/delete', 'deletePost')->name('post.delete');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
