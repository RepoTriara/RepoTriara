<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TblFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class CleanExpiredFiles extends Command
{
    protected $signature = 'clean:expired-files';
    protected $description = 'Elimina archivos expirados del sistema de archivos y sus registros en la base de datos.';

    public function handle()
    {
        $expiredFiles = TblFile::where('expires', true)
            ->where('expiry_date', '<', now())
            ->get();

        foreach ($expiredFiles as $file) {
            $filePath = storage_path('app/private/uploads/' . $file->url);

            if (File::exists($filePath)) {
                try {
                    // Eliminar el archivo del sistema de archivos
                    Storage::disk('private')->delete('uploads/' . $file->url);

                    Log::info("Archivo expirado eliminado del sistema de archivos: " . $file->filename);
                } catch (\Exception $e) {
                    Log::error("Error al eliminar archivo expirado " . $file->filename . ": " . $e->getMessage());
                }
            } else {
                Log::warning("Archivo expirado no encontrado en el sistema de archivos: " . $file->filename);
            }

            // Eliminar el registro de la base de datos
            try {
                $file->delete();
                Log::info("Registro de archivo expirado eliminado de la base de datos: " . $file->filename);
            } catch (\Exception $e) {
                Log::error("Error al eliminar registro de archivo expirado " . $file->filename . " de la base de datos: " . $e->getMessage());
            }
        }

        $this->info('Archivos expirados y sus registros eliminados del sistema de archivos y la base de datos.');
    }
}
