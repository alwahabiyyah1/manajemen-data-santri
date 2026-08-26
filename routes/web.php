<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\WaliLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SantriController as AdminSantri;
use App\Http\Controllers\Admin\WaliSantriController as AdminWali;
use App\Http\Controllers\Wali\DashboardController as WaliDashboard;
use App\Http\Controllers\Wali\SantriController as WaliSantri;

// Root redirect
Route::get('/', fn() => view('welcome'));

// ─── ADMIN AUTH ──────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest.admin')->group(function () {
        Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth.admin')->group(function () {
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('dashboard/verify-santri', [AdminDashboard::class, 'verifySantri'])->name('dashboard.verify');

        // Santri Custom Routes
        Route::get('santri/export', [AdminSantri::class, 'exportExcel'])->name('santri.export');
        Route::post('santri/save-step', [AdminSantri::class, 'saveStep'])->name('santri.saveStep');
        Route::get('santri/preview', [AdminSantri::class, 'preview'])->name('santri.preview');
        Route::post('santri/store-final', [AdminSantri::class, 'storeFinal'])->name('santri.storeFinal');

        // Santri CRUD
        Route::resource('santri', AdminSantri::class);

        // Wali Santri CRUD
        Route::resource('wali', AdminWali::class)->except(['show']);
    });
});

// ─── WALI AUTH ───────────────────────────────────────────────────────────────
Route::prefix('wali')->name('wali.')->group(function () {
    Route::middleware('guest.wali')->group(function () {
        Route::get('login', [WaliLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [WaliLoginController::class, 'login'])->name('login.post');
    });

    Route::middleware('auth.wali')->group(function () {
        Route::post('logout', [WaliLoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [WaliDashboard::class, 'index'])->name('dashboard');
        Route::get('santri', [WaliSantri::class, 'index'])->name('santri.index');
        Route::get('santri/{id}', [WaliSantri::class, 'show'])->name('santri.show');
        Route::get('santri/{id}/edit', [WaliSantri::class, 'edit'])->name('santri.edit');
        Route::put('santri/{id}', [WaliSantri::class, 'update'])->name('santri.update');
    });
});

Route::get('/debug-session', function () {
    return [
        'admin' => auth()->guard('admin')->check(),
        'admin_user' => auth()->guard('admin')->user(),
        'wali' => auth()->guard('wali')->check(),
        'wali_user' => auth()->guard('wali')->user(),
        'session_id' => session()->getId(),
    ];
});
