<?php
use App\Http\Controllers\Add_ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserSystemController;
use App\Http\Controllers\CompanyController;

// Ruta de bienvenida
//Route::get('/', function () {
  //  return view('welcome');
//})->name('welcome');

Route::redirect('/', '/login');


// Ruta genérica del dashboard protegida por autenticación (para niveles 8 y 10)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/add_client', [Add_ClientController::class, 'create'])->name('add_client');

Route::post('/add_client', [Add_ClientController::class, 'store'])->name('add_client');


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

    Route::get('/add_company', function () {
        return view('companies.add_company');
    })->name('add_company');

    Route::get('/manage_company', function () {
        return view('companies.manage_company');
    })->name('manage_company');


    Route::get('/add_user', [UserSystemController::class, 'create'])->name('add_user');

    Route::post('/add_user', [UserSystemController::class, 'store'])->name('users.store');

    Route::get('/manage-users', [UserSystemController::class, 'index'])->name('manage_users');
    Route::get('users', [UserSystemController::class, 'index'])->name('system_users.index');
    Route::post('system_users/bulk_action', [UserSystemController::class, 'bulkAction'])->name('system_users.bulk_action');
    Route::get('system_users/{id}/edit', [UserSystemController::class, 'edit'])->name('system_users.edit');
    Route::put('system_users/{id}', [UserSystemController::class, 'update'])->name('system_users.update');

    Route::middleware('auth')->group(function () {
        Route::get('/add_company', [CompanyController::class, 'create'])->name('add_company');
        Route::post('/add_company', [CompanyController::class, 'store'])->name('company.store');
    });

});

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';

