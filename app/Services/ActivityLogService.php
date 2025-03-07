<?php
namespace App\Services;

use App\Models\TblActionsLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Registra una acción en la tabla de logs.
     *
     * @param int $action Código de la acción realizada.
     * @param string|null $description Descripción de la acción.
     * @param array $data Datos adicionales relacionados con la acción.
     */
    public static function log(int $action, ?string $description = null, array $data = []): void
    {
        TblActionsLog::create([
            'timestamp' => now(),
            'action' => $action,
            'owner_id' => Auth::id() ?? 0,
            'owner_user' => Auth::user()->name ?? 'Sistema',
            'affected_file' => $data['affected_file'] ?? null,
            'affected_account' => $data['affected_account'] ?? null,
            'affected_file_name' => $data['affected_file_name'] ?? null,
            'affected_account_name' => $data['affected_account_name'] ?? null,
        ]);
    }
}
