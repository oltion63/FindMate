<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CompanyController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');
Route::get('/home', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware('admin')->prefix('admin')->controller(AdminController::class)->group(function () {
    Route::get('/dashboard','index')->name('dashboard');
    Route::delete('/user/{user}/delete', 'deleteUser')->name('user.delete');
    Route::delete('/post/{post}/delete', 'deletePost')->name('post.delete');
});

Route::middleware(['auth'])->prefix('jobs')->name('jobs.')->controller(PostController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('/create',  'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{job}', 'show')->name('show');
    Route::get('/{job}/edit', 'edit')->name('edit');
    Route::patch('/{job}', 'update')->name('update');
    Route::delete('/{job}/destroy',  'destroy')->name('destroy');
    Route::post('/storeSaved', 'storeSaved')->name('storeSaved');
    Route::delete('/deleteSaved/{id}', 'deleteSaved')->name('deleteSaved');
});


Route::middleware('auth')->controller(CvController::class)->group(function () {
    Route::post('/storeCV', 'storeCv')->name('storeCV');
    Route::post('/updateCV',  'updateCV')->name('updateCV');
    Route::delete('/deleteCV/{cv}',  'deleteCV')->name('deleteCV');
});



Route::middleware('auth')->controller(ApplicationController::class)->group(function () {
    Route::post('/storeApplication', 'store')->name('storeApplication');
    Route::post('/application/{application}/accept', 'accept')->name('application.accept');
    Route::post('/application/{application}/reject', 'reject')->name('application.reject');
    Route::delete('/application/{id}/delete', 'delete')->name('application.delete');
});

Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profilePage', 'index')->name('profilePage');
    Route::get('/profile',  'edit')->name('profile.edit');
    Route::patch('/profile',  'update')->name('profile.update');
    Route::delete('/profile',  'destroy')->name('profile.destroy');
    Route::post('profile/update-image',  'updateImage')->name('updateUserImage');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
