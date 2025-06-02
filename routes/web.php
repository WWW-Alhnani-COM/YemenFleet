<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/toggle-dark-mode', function() {
//     session(['dark_mode' => !session('dark_mode')]);
//     return back();
// });

Route::get('/', function () {
    return view('dashboard'); // سيُظهر ملف home.blade.php
});
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
