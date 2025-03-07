<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TblFile; // Asegúrate de tener el modelo correcto
use Illuminate\Support\Facades\Log;

class DeleteExpiredFiles extends Command
{
    /**
     * Nombre y descripción del comando.
     */
    protected $signature = 'files:delete-expired';
    protected $description = 'Elimina los archivos con expires = 0 de la tabla tbl_files';

    /**
     * Ejecutar el comando.
     */
    public function handle()
    {
        $count = TblFile::where('expires', 0)->delete();

        Log::info("Se eliminaron {$count} archivos expirados.");
        $this->info("Se eliminaron {$count} archivos expirados.");
    }
}
