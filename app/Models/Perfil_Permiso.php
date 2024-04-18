<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil_Permiso extends Model
{
    protected $table = 'perfil_permiso';
    protected $fillable = ['id', 'id_perfil', 'id_permisos '];
}
