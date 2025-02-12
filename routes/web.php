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
use App\Http\Controllers\StatisticsController;


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
})->middleware(['auth', 'level:8,10,0'])->name('dashboard');



//Estadisticas Temporales

Route::get('/statistics/data', [StatisticsController::class, 'getStatistics']);


//Limpiar archivos temporales
Route::post('/clear-temporary-files', [FilesController::class, 'clearTemporaryFiles'])->middleware(['auth', 'level:0,8,10'])->name('files.clearTemporaryFiles');
Route::post('/files/clearTemporaryFiles', [FilesController::class, 'clearTemporaryFiles'])->middleware(['auth', 'level:0,8,10'])->name('files.clearTemporaryFiles');
// Ruta para el level 0
Route::get('/my_files', action: [FilesController::class, 'myFiles'])->name('my_files');
Route::get('/manage-files', action: [FilesController::class, 'manageFiles'])->middleware(['auth', 'level:0'])->name('manage-files');
Route::get('/direct-download/{id}', [FilesController::class, 'directDownload'])->name('file.directDownload');
Route::post('/download-compresed', [FilesController::class, 'downloadCompresed'])->name('files.downloadCompresed');


// Rutas para el manejo de clientes
Route::middleware('auth', 'level:8,10')->group(function () {
Route::get('/add_client', [ClientController::class, 'create'])->name('add_client');
Route::post('/add_client', [ClientController::class, 'store'])->name('add_client');
Route::get('/customer_manager', [ClientController::class, 'index'])->name('customer_manager');
Route::post('/customers/bulk_Action', [ClientController::class, 'bulkAction'])->name('customers.bulk_Action');
Route::get('/customer_manager/{id}/edit', [ClientController::class, 'edit'])->name('customer_manager.edit');
Route::put('/customer_manager/{id}', [ClientController::class, 'update'])->name('customer_manager.update');
});


// Rutas para el perfil de usuario
Route::middleware('auth', 'level:0,8,10')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta para archivos
Route::middleware('auth')->group(function () {
    Route::get('/upload', [FilesController::class, 'uploadView'])->middleware(['auth', 'level:0,8,10'])->name('upload');
    Route::post('/files/upload-process', [FilesController::class, 'uploadProcess'])->middleware(['auth', 'level:0,8,10'])->name('files.upload_process');
    Route::post('/file/store', [FilesController::class, 'store'])->middleware(['auth', 'level:0,8,10'])->name('file.store');
    Route::get('/files/upload-process-view', [FilesController::class, 'uploadProcessView'])->middleware(['auth', 'level:0,8,10'])->name('files.upload_process.view');
    Route::get('/file_manager', [FilesController::class, 'index'])->middleware(['auth', 'level:8,10'])->name('file_manager');
    Route::get('/files/download/{id}', [FilesController::class, 'download'])->middleware(['auth', 'level:0,8,10'])->name('files.download');
    Route::get('/file_manager/edit/{id}', [FilesController::class, 'edit'])->middleware(['auth', 'level:0,8,10'])->name('files.edit');
    Route::put('/file_manager/update/{id}', [FilesController::class, 'update'])->middleware(['auth', 'level:0,8,10'])->name('files.update');
    Route::post('/files/bulk-action', [FilesController::class, 'bulkAction'])->middleware(['auth', 'level:8,10'])->name('files.bulk-action');
    Route::post('/files/download-compressed', [FilesController::class, 'downloadCompressed'])->middleware(['auth', 'level:0,8,10'])->name('files.download-compressed');
    Route::get('/download', [FilesController::class, 'download'])->middleware(['auth', 'level:0,8,10'])->name('download.file');
    Route::get('/files/{fileId}/edit-basic', [FilesController::class, 'editBasic'])->middleware(['auth', 'level:0'])->name('files.editBasic');
    Route::get('/file/download/{id}/{token}', [FilesController::class, 'showDownloadView'])->name('file.showDownload')->withoutMiddleware('auth');
});

// Rutas para el manejo de usuarios
Route::middleware('auth', 'level:10')->group(function () {
Route::get('/add_user', [UserSystemController::class, 'create'])->name('add_user');
Route::post('/add_user', [UserSystemController::class, 'store'])->name('users.store');
Route::get('/manage-users', [UserSystemController::class, 'index'])->name('manage_users');
Route::get('users', [UserSystemController::class, 'index'])->name('system_users.index');
Route::post('system_users/bulk_action', [UserSystemController::class, 'bulkAction'])->name('system_users.bulk_action');
Route::get('system_users/{id}/edit', [UserSystemController::class, 'edit'])->name('system_users.edit');
Route::put('system_users/{id}', [UserSystemController::class, 'update'])->name('system_users.update');
});

// Rutas para la gestión de grupos y archivos en empresas
Route::middleware('auth' ,'level:8,10')->group(function () {
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
Route::middleware('auth' ,'level:10')->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk_delete');
        Route::get('/categories/{category}/files', [CategoryController::class, 'showFiles'])->name('categories.showFiles');
        Route::get('/files', [FilesController::class, 'index'])->name('files.index');
    });
});

// Incluir las rutas de autenticación
require __DIR__ . '/auth.php';
