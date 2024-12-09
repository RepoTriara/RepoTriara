<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;
    protected $table = 'tbl_users'; // Cambia 'users' por el nombre de tu tabla si es diferente
    /**
     * The attributes that are mass assignable.
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
    public function downloads(){     return $this->hasMany(TblDownload::class, 'user_id', 'id'); }
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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
   
    public function fileRelations(){     return $this->hasMany(TblFileRelation::class, 'client_id', 'id');}


}
