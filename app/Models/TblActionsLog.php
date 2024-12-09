<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblActionsLog extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_actions_log';

    // Clave primaria de la tabla
    protected $primaryKey = 'id';

    // La clave primaria es autoincremental
    public $incrementing = true;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // Indica que no se manejarán automáticamente las marcas de tiempo (created_at y updated_at)
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'timestamp',
        'action',
        'owner_id',
        'owner_user',
        'affected_file',
        'affected_account',
        'affected_file_name',
        'affected_account_name',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'action' => 'integer',
        'owner_id' => 'integer',
        'affected_file' => 'integer',
        'affected_account' => 'integer',
    ];

    /**
     * Relación con el usuario propietario (Owner).
     * Asume que hay un modelo TblUser relacionado con la clave `owner_id`.
     */
    public function owner()
    {
        return $this->belongsTo(TblUser::class, 'owner_id', 'id');
    }

    /**
     * Relación con el archivo afectado (Affected File).
     * Asume que hay un modelo TblFile relacionado con la clave `affected_file`.
     */
    public function affectedFile()
    {
        return $this->belongsTo(TblFile::class, 'affected_file', 'id');
    }

    /**
     * Relación con la cuenta afectada (Affected Account).
     * Asume que hay un modelo TblAccount relacionado con la clave `affected_account`.
     */
    public function affectedAccount()
    {
        return $this->belongsTo(TblAccount::class, 'affected_account', 'id');
    }
}

