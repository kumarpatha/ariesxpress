<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ConsignmentController;
use App\Http\Controllers\PublicInquiryController;
use App\Http\Controllers\TrackingController;

// ── Public Website Routes ───────────────────────────────────────────────────
Route::view('/', 'public.home')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::view('/services', 'public.services')->name('services');
Route::view('/contact', 'public.contact')->name('contact');
Route::post('/inquiries', [PublicInquiryController::class, 'store'])->name('inquiries.store');

// ── Public Tracking Routes ──────────────────────────────────────────────────
Route::get('/track', [TrackingController::class, 'index'])->name('tracking.index');
Route::post('/track', [TrackingController::class, 'track'])->name('tracking.track');

// ── Admin Routes ────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only routes
    Route::middleware(['web', 'guest:admin'])->group(function () {
        Route::get('login',  [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');
    });

    // Authenticated admin routes
    Route::middleware(['web', 'auth:admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Consignment CRUD
        Route::resource('consignments', ConsignmentController::class);

        // Status update
        Route::post(
            'consignments/{consignment}/update-status',
            [ConsignmentController::class, 'updateStatus']
        )->name('consignments.update-status');
    });
});

// Logout
Route::post('admin/logout', [AuthController::class, 'logout'])->middleware('web')->name('admin.logout');
