<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'tbl_users'; // Nombre de la tabla en la base de datos

    /**
     * Los atributos que se pueden asignar de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user',
        'password',
        'name',
        'email',
        'level',
        'timestamp',
        'address',
        'phone',
        'notify',
        'contact',
        'created_by',
        'active',
        'account_requested',
        'account_denied',
        'max_file_size',
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser casteados.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con la tabla `tbl_downloads`.
     */
    public function downloads()
    {
        return $this->hasMany(TblDownload::class, 'user_id', 'id');
    }

    /**
     * Relación con la tabla `tbl_files_relations`.
     */
    public function fileRelations()
    {
        return $this->hasMany(TblFileRelation::class, 'client_id', 'id');
    }

    /**
     * Métodos para identificar roles según el `level`.
     */
    public function isLevel10()
    {
        return $this->level == 10;
    }

    public function isLevel9()
    {
        return $this->level == 9;
    }

    public function isLevel8()
    {
        return $this->level == 8;
    }

    public function isLevel7()
    {
        return $this->level == 7;
    }

    public function isStandardUser()
    {
        return $this->level == 0;
    }

    /**
     * Método genérico para verificar si el usuario tiene un nivel específico.
     */
    public function hasRole($level)
    {
        return $this->level == $level;
    }

  // En el modelo User (User.php)
// Modelo User.php
public function groups()
{
    return $this->belongsToMany(Groups::class, 'tbl_members', 'client_id', 'group_id');
}


}
