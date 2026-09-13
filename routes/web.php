<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('dashboard', DashboardController::class)->only(['index'])->names(['index' => 'dashboard']);
    Route::resource('connections', ConnectionController::class);
    Route::resource('billing', BillingController::class);
    Route::resource('packages', PackageController::class)->only(['index']);
    Route::resource('usage', UsageController::class);
    Route::resource('support', SupportController::class);
    Route::resource('settings', SettingController::class)->only(['index', 'update']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->except(['show']);
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
