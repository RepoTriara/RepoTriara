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
<<<<<<< HEAD

    // Rutas específicas para cada nivel de usuario
    Route::get('/dashboard/level10', function () {
        return view('dashboard_level10');
    })->name('dashboard.level10');

    Route::get('/dashboard/level9', function () {
        return view('dashboard_level9');
    })->name('dashboard.level9');

    Route::get('/dashboard/level8', function () {
        return view('dashboard_level8');
    })->name('dashboard.level8');

    Route::get('/dashboard/level7', function () {
        return view('dashboard_level7');
    })->name('dashboard.level7');

    Route::get('/dashboard/user', function () {
        return view('dashboard_user');
    })->name('dashboard.user');

    
    Route::get('/upload', function () {
        return view('files.upload');  
    })->name('upload');

    Route::get('/file_manager', function () {
        return view('files.file_manager');  
    })->name('file_manager');

    Route::get('/search_orphan_files', function () {
        return view('files.search_orphan_files');  
    })->name('search_orphan_files');

    Route::get('/customer_manager', function () {
        return view('customers.customer_manager');  
    })->name('customer_manager');
    
=======
>>>>>>> cf0998bc85e8cce675c44ba6994b8190a1e59a4c
});

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
