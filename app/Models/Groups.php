<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'tbl_groups';

    // Desactivar timestamps automáticos (ya que tienes un campo timestamp personalizado)
    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'name',
        'description',
        'public',
        'public_token',
    ];

    public function fileRelations(){     return $this->hasMany(TblFileRelation::class, 'group_id', 'id'); }

}
