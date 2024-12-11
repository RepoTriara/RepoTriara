<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Ruta de bienvenida
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Ruta genérica del dashboard protegida por autenticación (para niveles 8 y 10)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta específica para nivel 0
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/level0', function () {
        return view('dashboard_level0');
    })->name('dashboard.level0');

    // Rutas para el perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
