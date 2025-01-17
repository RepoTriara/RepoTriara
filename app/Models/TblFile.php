<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TblFile extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_files';

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
        'url',
        'original_url',
        'filename',
        'description',
        'timestamp',
        'uploader',
        'expires',
        'expiry_date',
        'public_allow',
        'public_token',
    ];

    // Cast de atributos para convertir tipos automáticamente
    protected $casts = [
        'timestamp' => 'datetime',
        'expiry_date' => 'datetime',
        'expires' => 'boolean',
        'public_allow' => 'boolean',
    ];

    /**
     * Relación con el modelo TblDownload.
     * Un archivo puede tener muchas descargas.
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(TblDownload::class, 'file_id', 'id');
    }

    /**
     * Relación con el modelo TblCategoryRelation.
     * Un archivo puede estar relacionado con muchas categorías.
     */
    public function categoryRelations(): HasMany
    {
        return $this->hasMany(TblCategoryRelation::class, 'file_id', 'id');
    }
    public function fileRelations()
{
    return $this->hasMany(TblFileRelation::class, 'file_id', 'id');
}

protected static function boot()
{
    parent::boot();

    static::creating(function ($file) {
        if (empty($file->public_token)) {
            $file->public_token = Str::random(32);
        }
    });
}

public function groups()
{
    return $this->belongsToMany(Groups::class, 'tbl_files_relations', 'file_id', 'group_id');
}

}
