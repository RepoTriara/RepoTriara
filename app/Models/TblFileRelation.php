<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblFileRelation extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_files_relations';

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
        'file_id',
        'client_id',
        'group_id',
        'folder_id',
        'hidden',
        'download_count',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'file_id' => 'integer',
        'client_id' => 'integer',
        'group_id' => 'integer',
        'folder_id' => 'integer',
        'hidden' => 'boolean',
        'download_count' => 'integer',
    ];

    /**
     * Relación con el modelo TblFile.
     * Un registro pertenece a un archivo.
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(TblFile::class, 'file_id', 'id');
    }

    /**
     * Relación con el modelo TblUser (Cliente).
     * Un registro pertenece a un cliente.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(TblUser::class, 'client_id', 'id');
    }

    /**
     * Relación con el modelo TblGroup.
     * Un registro pertenece a un grupo.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(TblGroup::class, 'group_id', 'id');
    }

    /**
     * Relación con el modelo TblFolder.
     * Un registro pertenece a una carpeta.
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(TblFolder::class, 'folder_id', 'id');
    }
}

