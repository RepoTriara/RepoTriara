<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'tbl_password_reset';

    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
        'timestamp',
        'used',
    ];

    /**
     * Relaciones con otros modelos.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}
