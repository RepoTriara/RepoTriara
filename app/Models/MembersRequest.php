<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersRequest extends Model
{
    use HasFactory;

    protected $table = 'tbl_members_requests';

    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'requested_by',
        'client_id',
        'group_id',
        'denied',
    ];

    

    // Relación con Users
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id'); 
    }

    // Relación con Groups
    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id'); 
    }
}
