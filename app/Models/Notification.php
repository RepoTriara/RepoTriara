<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'tbl_notifications';

    // Desactivar timestamps automáticos (ya que tienes un campo timestamp personalizado)
    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'file_id',
        'client_id',
        'upload_type',
        'sent_status',
        'times_failed',
    ];

    /**
     * Relaciones con otros modelos.
     */

    // Relación con el archivo (si existe un modelo File)
    public function file()
    {
        return $this->belongsTo(TblFile::class, 'file_id'); // Relación con el modelo File
    }

    // Relación con el cliente (si existe un modelo Client)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id'); // Relación con el modelo Client
    }
}
