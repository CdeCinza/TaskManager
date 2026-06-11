<?php

use App\Http\Controllers\AuthController;
use App\Livewire\ShowBoard;
use App\Models\Board;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $primeiroBoard = Board::first();
    
    if (!$primeiroBoard) {
        return "Nenhum board encontrado. Você rodou as migrations e os seeders?";
    }

    return redirect()->route('board.show', $primeiroBoard->id);
})->middleware('auth');

Route::get('/board/{board}', ShowBoard::class)->name('board.show')->middleware('auth');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

