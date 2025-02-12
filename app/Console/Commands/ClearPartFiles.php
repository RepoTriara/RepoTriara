<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearPartFiles extends Command
{
    protected $signature = 'files:clear-part-files';
    protected $description = 'Elimina archivos .part en el directorio temporal';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $tempDir = storage_path('app/private/uploads/tmp');
        $partFiles = glob($tempDir . DIRECTORY_SEPARATOR . '*.part');

        foreach ($partFiles as $partFile) {
            if (file_exists($partFile)) {
                unlink($partFile); // Eliminar archivo .part
                $this->info("Archivo eliminado: $partFile");
            }
        }

        $this->info('Archivos .part eliminados correctamente.');
    }
}
