<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'tbl_members';

    // Desactivar timestamps automáticos (ya que tienes un campo timestamp personalizado)
    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'added_by',
        'client_id',
        'group_id',
    ];

    /**
     * Relaciones con otros modelos.
     */

    // Relación con el cliente
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id'); 
    }

    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id'); 
    }
}
