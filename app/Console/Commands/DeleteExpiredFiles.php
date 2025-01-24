<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TblFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class DeleteExpiredFiles extends Command
{
    protected $signature = 'files:delete-expired';
    protected $description = 'Eliminar archivos expirados según la fecha de expiración.';

    public function handle()
    {
        $expiredFiles = TblFile::where('expires', 1)
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())
            ->get();

        if ($expiredFiles->isEmpty()) {
            $this->info('No hay archivos expirados para eliminar.');
            return;
        }

        foreach ($expiredFiles as $file) {
            try {
                $filePath = storage_path('app/private/uploads/' . $file->url);


                Log::info("Intentando eliminar archivo: $filePath");

                if (File::exists($filePath)) {
                    File::delete($filePath);
                    Log::info("Archivo eliminado correctamente: $filePath");
                } else {
                    Log::warning("Archivo no encontrado: $filePath");
                }

                $file->delete();
                $this->info("Archivo eliminado de la base de datos: {$file->filename}");
            } catch (\Exception $e) {
                Log::error("Error al eliminar archivo: {$file->filename}", ['error' => $e->getMessage()]);
                $this->error("Error al eliminar archivo: {$file->filename}");
            }
        }

        $this->info('Proceso de eliminación de archivos expirados completado.');
    }
}
