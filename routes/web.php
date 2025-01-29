<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserSystemController;
use App\Http\Controllers\CompanyController;
use App\Models\TblFile;
use Illuminate\Support\Str;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FilesController;
use Carbon\Carbon;

Route::get('/test-timezone', function () {
    return response()->json([
        'timezone' => config('app.timezone'),
        'current_time' => Carbon::now()->setTimezone(config('app.timezone'))->toDateTimeString(),
    ]);
});
Route::redirect('/', '/login');

// Ruta genérica del dashboard protegida por autenticación (para level 8 y 10)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para el level 0
Route::get('/my_files', action: [FilesController::class, 'myFiles'])->name('my_files');
Route::get('/manage-files', action: [FilesController::class, 'manageFiles'])->name('manage-files');
Route::get('/direct-download/{id}', [FilesController::class, 'directDownload'])->name('file.directDownload');
Route::post('/download-compresed', [FilesController::class, 'downloadCompresed'])->name('files.downloadCompresed');




// Rutas para el manejo de clientes
Route::get('/add_client', [ClientController::class, 'create'])->name('add_client');
Route::post('/add_client', [ClientController::class, 'store'])->name('add_client');
Route::get('/customer_manager', [ClientController::class, 'index'])->name('customer_manager');
Route::post('/customers/bulk_Action', [ClientController::class, 'bulkAction'])->name('customers.bulk_Action');
// Ruta para mostrar el formulario de edición
Route::get('/customer_manager/{id}/edit', [ClientController::class, 'edit'])->name('customer_manager.edit');
// Ruta para actualizar los datos del cliente
Route::put('/customer_manager/{id}', [ClientController::class, 'update'])->name('customer_manager.update');

// Rutas para el perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para subir archivos
Route::middleware('auth')->group(function () {
    Route::get('/upload', [FilesController::class, 'uploadView'])->name('upload');
    Route::post('/files/upload-process', [FilesController::class, 'uploadProcess'])->name('files.upload_process');
    Route::post('/file/store', [FilesController::class, 'store'])->name('file.store');
    Route::get('/files/upload-process-view', [FilesController::class, 'uploadProcessView'])->name('files.upload_process.view');
    Route::get('/file_manager', [FilesController::class, 'index'])->name('file_manager');
    Route::get('/files/download/{id}', [FilesController::class, 'download'])->name('files.download');
    Route::get('/file_manager/edit/{id}', [FilesController::class, 'edit'])->name('files.edit');
    Route::put('/file_manager/update/{id}', [FilesController::class, 'update'])->name('files.update');
    Route::post('/files/bulk-action', [FilesController::class, 'bulkAction'])->name('files.bulk-action');
    Route::post('/files/download-compressed', [FilesController::class, 'downloadCompressed'])->name('files.download-compressed');
    Route::get('/download', [FilesController::class, 'download'])->name('download.file');
    Route::get('/files/{fileId}/edit-basic', [FilesController::class, 'editBasic'])->name('files.editBasic');
});

// Rutas para la gestión de empresas
Route::middleware('auth')->group(function () {
    Route::get('/add_company', function () {
        return view('companies.add_company');
    })->name('add_company');

    Route::get('/manage_company', function () {
        return view('companies.manage_company');
    })->name('manage_company');
});

// Rutas para el manejo de usuarios
Route::get('/add_user', [UserSystemController::class, 'create'])->name('add_user');
Route::post('/add_user', [UserSystemController::class, 'store'])->name('users.store');
Route::get('/manage-users', [UserSystemController::class, 'index'])->name('manage_users');
Route::get('users', [UserSystemController::class, 'index'])->name('system_users.index');
Route::post('system_users/bulk_action', [UserSystemController::class, 'bulkAction'])->name('system_users.bulk_action');
Route::get('system_users/{id}/edit', [UserSystemController::class, 'edit'])->name('system_users.edit');
Route::put('system_users/{id}', [UserSystemController::class, 'update'])->name('system_users.update');

// Rutas para la gestión de grupos y archivos en empresas
Route::middleware('auth')->group(function () {
    Route::get('/add_company', [CompanyController::class, 'create'])->name('add_company');
    Route::post('/add_company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/manage_company', [CompanyController::class, 'manageCompany'])->name('manage_company');
    Route::post('/groups/bulk_action', [CompanyController::class, 'bulkAction'])->name('groups.bulk_action');
    Route::get('/groups/{id}/edit', [CompanyController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{id}', [CompanyController::class, 'update'])->name('groups.update');
    Route::get('/groups/{id}/files', [CompanyController::class, 'manageFiles'])->name('groups.files');
    Route::get('/files/download/{id}', [CompanyController::class, 'download'])->name('files.download');
    Route::get('/companies/files/edit/{id}', [CompanyController::class, 'editFile'])->name('companies.files.edit');
    Route::put('/companies/files/update/{id}', [CompanyController::class, 'updateFile'])->name('companies.files.update');

    Route::get('/manage-files/{groupId}', [CompanyController::class, 'manageFiles'])->name('files.manage');
    Route::post('/manage-files/{groupId}/bulk-action', [CompanyController::class, 'bulkAction'])->name('files.bulk_action');
    Route::post('/files/group-bulk-action/{groupId}', [CompanyController::class, 'bulkActionFiles'])->name('files.group-bulk-action');
});

// Generación de tokens públicos para archivos
Route::middleware('auth')->group(function () {
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
});

// Rutas para la gestión de categorías
Route::middleware('auth')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk_delete');
        Route::get('/categories/{category}/files', [CategoryController::class, 'showFiles'])->name('categories.showFiles');
    });
    Route::get('/files', [FilesController::class, 'index'])->name('files.index');
});

// Incluir las rutas de autenticación
require __DIR__ . '/auth.php';
