<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckSheetController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\CheckItemController;

// Root
Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Check Sheet
    Route::get('/checksheet',            [CheckSheetController::class, 'index'])->name('checksheet.index');
    Route::get('/checksheet/create',     [CheckSheetController::class, 'create'])->name('checksheet.create');
    Route::post('/checksheet',           [CheckSheetController::class, 'store'])->name('checksheet.store');
    Route::get('/checksheet/{id}',       [CheckSheetController::class, 'show'])->name('checksheet.show');

    // Setting
    Route::get('/setting', fn() => view('setting.index'))->name('setting');
    Route::resource('/setting/driver',    DriverController::class)->names('driver');
    Route::resource('/setting/vehicle',   VehicleController::class)->names('vehicle');
    Route::resource('/setting/checkitem', CheckItemController::class)->names('checkitem');
    Route::patch('/setting/checkitem/{checkitem}/toggle',
        [CheckItemController::class, 'toggleActive'])->name('checkitem.toggle');
});