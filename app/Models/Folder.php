<?php

namespace App\Models;
use App\Models\User;  // Importa el modelo User
use App\Models\Groups;  // Importa el modelo User

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $table = 'tbl_folders';

    // Desactivar timestamps automáticos (ya que tienes un campo timestamp personalizado)
    public $timestamps = false;

    /**
     * Atributos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'parent',
        'name',
        'timestamp',
        'client_id',
        'group_id',
    ];

   

    public function parentFolder()
    {
        return $this->belongsTo(Folder::class, 'parent');
    }

    public function childFolders()
    {
        return $this->hasMany(Folder::class, 'parent');
    }

    //  (si existe un modelo User)
    public function client()
{
    return $this->belongsTo(User::class, 'client_id');
}


    // (si existe un modelo Group)
    public function group()
    {
        return $this->belongsTo(Groups::class, 'group_id');
    }
    public function fileRelations(){     return $this->hasMany(TblFileRelation::class, 'folder_id', 'id'); }
 
}
