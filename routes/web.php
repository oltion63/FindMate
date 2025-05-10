<?php

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

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
