<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ArmadaController as AdminArmadaController;
use App\Http\Controllers\Public\ArmadaController as PublicArmadaController;
use App\Http\Controllers\Admin\RuteController as AdminRuteController;
use App\Http\Controllers\Public\RuteController as PublicRuteController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Public\DriverController as PublicDriverController;
use App\Http\Controllers\Admin\TrackingController as AdminTrackingController;
use App\Http\Controllers\Public\TrackingController as PublicTrackingController;
use App\Http\Controllers\Admin\GudangController as AdminGudangController;
use App\Http\Controllers\Public\GudangController as PublicGudangController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Public\ServiceController as PublicServiceController;
use App\Http\Controllers\Admin\TarifController as AdminTarifController;
use App\Http\Controllers\Public\TarifController as PublicTarifController;
use App\Http\Controllers\Admin\TarifPerKgController as AdminTarifPerKgController;
use App\Http\Controllers\Admin\DiskonController as AdminDiskonController;

// ============================================
// Route Public (Tanpa Autentikasi)
// ============================================
Route::get('/', function () {
    return view('public.wellcome');
})->name('home');

Route::get('/armada', [PublicArmadaController::class, 'index'])->name('public.armada.index');
Route::get('/cek-area-layanan', [PublicRuteController::class, 'index'])->name('public.rute.index');
Route::get('/profil-tim', [PublicDriverController::class, 'index'])->name('public.driver.index');
Route::get('/cek-resi', [PublicTrackingController::class, 'index'])->name('public.tracking.index');
Route::post('/cek-resi', [PublicTrackingController::class, 'cek'])->name('public.tracking.cek');
Route::get('/lokasi-gudang', [PublicGudangController::class, 'index'])->name('public.gudang.index');

// Serve storage files when `public/storage` symlink is not present
Route::get('/storage-files/{path}', function ($path) {
    $path = base64_decode($path);
    $full = storage_path('app/public/' . $path);
    if (!file_exists($full)) {
        abort(404);
    }
    return response()->file($full);
})->where('path', '.*')->name('public.storage.file');
Route::get('/info-perawatan', [PublicServiceController::class, 'index'])->name('public.service.index');
Route::get('/cek-ongkir', [PublicTarifController::class, 'index'])->name('public.tarif.index');
Route::post('/cek-ongkir', [PublicTarifController::class, 'calculate'])->name('public.tarif.calculate');

// ============================================
// Route Auth (Laravel Breeze)
// ============================================
require __DIR__.'/auth.php';

// Profile (edit/update/delete) — used by tests and navigation
Route::middleware('auth')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Generic dashboard shortcut — redirects users to the correct dashboard
Route::get('/dashboard', function () {
    if (! auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    // Admins go to the admin dashboard
    if ($user->hasAnyRole(['Super Admin', 'Staff'])) {
        return redirect()->route('admin.dashboard');
    }

    // Other authenticated users go to home
    return redirect()->route('home');
})->name('dashboard');

// ============================================
// Route Admin (Super Admin & Staff Only)
// ============================================
Route::middleware(['auth', 'role:Super Admin|Staff'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Resource Routes (CRUD)
    Route::resource('armada', AdminArmadaController::class);
    Route::resource('rute', AdminRuteController::class);
    Route::resource('driver', AdminDriverController::class);
    Route::resource('tracking', AdminTrackingController::class);
    Route::resource('gudang', AdminGudangController::class);
    Route::resource('service', AdminServiceController::class);
    Route::resource('tarif', AdminTarifController::class);
    Route::resource('tarif-per-kg', AdminTarifPerKgController::class);
    Route::resource('diskon', AdminDiskonController::class);

    // Gudang Stock Management Routes
    Route::post('gudang/{gudang}/add-stock', [AdminGudangController::class, 'addStock'])->name('gudang.add-stock');
    Route::post('gudang/{gudang}/reduce-stock', [AdminGudangController::class, 'reduceStock'])->name('gudang.reduce-stock');

    // Notifications
    Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'show'])->name('notifications.show');
    Route::post('notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    Route::resource('user', App\Http\Controllers\Admin\UserController::class)->middleware('role:Super Admin');
});