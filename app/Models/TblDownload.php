<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblDownload extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_downloads';

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
        'user_id',
        'file_id',
        'timestamp',
        'remote_ip',
        'remote_host',
        'anonymous',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'user_id' => 'integer',
        'file_id' => 'integer',
        'anonymous' => 'boolean',
    ];

    /**
     * Relación con el modelo TblUser.
     * Un registro de descarga pertenece a un usuario.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Relación con el modelo TblFile.
     * Un registro de descarga pertenece a un archivo.
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(TblFile::class, 'file_id', 'id');
    }
}

