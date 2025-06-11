<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\GenerateReportController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CvController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('profilePage');
        }
    }
    return Inertia::render('Welcome');
})->name('welcome');

Route::get('/home', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('profilePage');
        }
    }
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
    Route::delete('/application/{application}/delete', 'delete')->name('application.delete');
});

Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profilePage', 'index')->name('profilePage');
    Route::get('/profile',  'edit')->name('profile.edit');
    Route::patch('/profile',  'update')->name('profile.update');
    Route::post('profile/update-image',  'updateImage')->name('updateUserImage');
});
Route::middleware(['auth'])->controller(CompanyController::class)->group(function () {
    Route::get('settings/company', 'edit')->name('editCompany');
    Route::get('/createCompany', 'create')->name('createCompany');
    Route::post('/storeCompany', 'store')->name('storeCompany');
    Route::patch('profile/{company}/update', 'update')->name('updateCompany');
    Route::post('profile/{company}/update-image', 'updateImage')->name('updateCompanyImage');
    Route::delete('profile/{company}/delete', 'deleteCompany')->name('deleteCompany');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/stripe-checkout', [PremiumController::class, 'checkout'])->name('premium.checkout');
    Route::get('/premium-success', [PremiumController::class, 'success'])->name('premium.success');
});

Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::patch('/markAsRead', [NotificationsController::class, 'markAsRead'])->name('markAsRead');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'googleCallback'])->name('auth.google.callback');


Route::middleware('auth')->group(function () {
    Route::get('/chat/room/{id}', [MessageController::class, 'room'])->name('room');
    Route::get('/chat/messages', [MessageController::class, 'messages']);
    Route::post('/chat/message', [MessageController::class, 'sendMessage']);
    Route::get('/chat/list', [MessageController::class, 'userRooms']);
    Route::get('/chat/rooms', [MessageController::class, 'roomsPage']);
});

Route::middleware(['auth', 'admin'])->controller(ReportController::class)->group(function () {
    Route::get('/admin/reports', 'index')->name('admin.reports');
    Route::post('/dismissReport/{id}',  'dismissed')->name('dismissedReport');
    Route::post('/reviewedReport/{id}',  'reviewed')->name('reviewedReport');
});
Route::post('/storeReport',  [ReportController::class ,'store'])->name('storeReport');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/reports/data', [GenerateReportController::class, 'index'])->name('dashboard.reports.data');
});

Route::get('/admin/manageusers', [AdminController::class, 'userposts'])->name('manageUsers');
Route::get('/employerApplications', [ProfileController::class, 'employerApp'])->name('employerApp');
Route::get('/employeeApplications', [ProfileController::class, 'employeeApps'])->name('employeeApps');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
