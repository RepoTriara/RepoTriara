<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Ruta de bienvenida
//Route::get('/', function () {
  //  return view('welcome');
//})->name('welcome');

Route::redirect('/', '/login');


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
    
    Route::get('/add_client', function () {
        return view('customers.add_client');  
    })->name('add_client');

    Route::get('/companies/add', function () {
        return view('companies.add_company');
    })->name('companies.add');

    Route::get('/companies/manage', function () {
        return view('companies.manage_company');
    })->name('companies.manage');
    
});

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
