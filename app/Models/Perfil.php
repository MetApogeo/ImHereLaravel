<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';
    protected $fillable = ['id', 'nombre'];

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'perfil_permisos', 'id_perfil', 'id_permisos');
    }
}
