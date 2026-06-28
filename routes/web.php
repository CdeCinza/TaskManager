<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Calendar;
use App\Livewire\Dashboard;
use App\Livewire\Reports;
use App\Livewire\ShowBoard;
use App\Livewire\Tickets;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Route::get('/dashboard', Dashboard::class)->name('dashboard')->middleware('auth');
Route::get('/calendar', Calendar::class)->name('calendar')->middleware('auth');
Route::get('/tickets', Tickets::class)->name('tickets')->middleware('auth');
Route::get('/reports', Reports::class)->name('reports')->middleware('auth');

Route::get('/board/{board}', ShowBoard::class)->name('board.show')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
