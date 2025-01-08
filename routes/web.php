<?php
use App\Http\Controllers\Add_ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserSystemController;
use App\Http\Controllers\CompanyController;
use App\Models\TblFile;
use Illuminate\Support\Str;
use App\Http\Controllers\CategoryController;

// Ruta de bienvenida
//Route::get('/', function () {
  //  return view('welcome');
//})->name('welcome');

Route::redirect('/', '/login');


// Ruta genérica del dashboard protegida por autenticación (para niveles 8 y 10)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/add_client', [Add_ClientController::class, 'create'])->name(name:'add_client');
Route::post('/add_client', [Add_ClientController::class, 'store'])->name(name:'add_client');
Route::get('/customer_manager', action: [Add_ClientController::class, 'index'])->name(name: 'customer_manager');
Route::post('/customers/bulk_Action', [Add_ClientController::class, 'bulkAction'])->name('customers.bulk_Action');
// Ruta para mostrar el formulario de edición
Route::get('/customer_manager/{id}/edit', [Add_ClientController::class, 'edit'])->name('customer_manager.edit');
// Ruta para actualizar los datos del cliente
Route::put('/customer_manager/{id}', [Add_ClientController::class, 'update'])->name('customer_manager.update');

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
        Route::get('/manage_company', [CompanyController::class, 'manageCompany'])->name('manage_company');
        Route::post('/groups/bulk_action', [CompanyController::class, 'bulkAction'])->name('groups.bulk_action');
        Route::get('/groups/{id}/edit', [CompanyController::class, 'edit'])->name('groups.edit');
        Route::put('/groups/{id}', [CompanyController::class, 'update'])->name('groups.update');
        Route::get('/groups/{id}/files', [CompanyController::class, 'manageFiles'])->name('groups.files');
        Route::get('/files/download/{id}', [CompanyController::class, 'download'])->name('files.download');
        Route::get('/files/edit/{id}', [CompanyController::class, 'editFile'])->name('files.edit');
        Route::put('/files/update/{id}', [CompanyController::class, 'updateFile'])->name('files.update');
        Route::get('/manage-files/{groupId}', [CompanyController::class, 'manageFiles'])->name('files.manage');
        Route::post('/manage-files/{groupId}/bulk-action', [CompanyController::class, 'bulkAction'])->name('files.bulk_action');
        Route::post('/files/bulk-action/{groupId}', [CompanyController::class, 'bulkActionFiles'])->name('files.bulk-action');


        Route::get('/fix-public-tokens', function () {
            $files = TblFile::whereNull('public_token')->orWhere('public_token', '')->get();

            foreach ($files as $file) {
                $file->public_token = Str::random(32);
                if ($file->save()) {
                    echo "Token generado para el archivo con ID: {$file->id}<br>";
                } else {
                    echo "Error al generar el token para el archivo con ID: {$file->id}<br>";
                }
            }

            return "Proceso completado.";
        });




        Route::post('customers/bulk_action', [UserSystemController::class, 'bulkAction'])->name('customers.bulk_action');
        Route::get('/customers', action: [Add_ClientController::class, 'index'])->name(name: 'customers.index');

    // Rutas para la gestión de categorías
    Route::prefix('categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk_delete');
        Route::get('/categories/{category}/files', [CategoryController::class, 'showFiles'])->name('categories.showFiles');
    });


    });

});

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';

