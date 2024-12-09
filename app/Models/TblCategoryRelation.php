<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TblCategoryRelation extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_categories_relations';

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
        'cat_id',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'file_id' => 'integer',
        'cat_id' => 'integer',
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
     * Relación con el modelo TblCategory.
     * Un registro pertenece a una categoría.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TblCategory::class, 'cat_id', 'id');
    }
}
