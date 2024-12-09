<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TblCategory extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_categories';

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
        'name',
        'parent',
        'description',
        'created_by',
        'timestamp',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'parent' => 'integer',
    ];

    /**
     * Relación para la categoría padre.
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(TblCategory::class, 'parent', 'id');
    }

    /**
     * Relación para las categorías hijas.
     */
    public function childCategories(): HasMany
    {
        return $this->hasMany(TblCategory::class, 'parent', 'id');
    }
    public function categoryRelations()
    {
        return $this->hasMany(TblCategoryRelation::class, 'cat_id', 'id');
    } 
}
