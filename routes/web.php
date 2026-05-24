<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlotController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\BurialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes WITHOUT destroy – destroy is admin-only below
    Route::resource('plots', PlotController::class)->except(['destroy']);
    Route::resource('owners', OwnerController::class)->except(['destroy']);
    Route::resource('deceased', DeceasedController::class)->except(['destroy']);
    Route::resource('burials', BurialController::class)->except(['destroy']);
    Route::resource('payments', PaymentController::class)->except(['destroy']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only: delete operations
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('plots/{plot}', [PlotController::class, 'destroy'])->name('plots.destroy');
        Route::delete('owners/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');
        Route::delete('deceased/{deceased}', [DeceasedController::class, 'destroy'])->name('deceased.destroy');
        Route::delete('burials/{burial}', [BurialController::class, 'destroy'])->name('burials.destroy');
        Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
    });

});

require __DIR__.'/auth.php';