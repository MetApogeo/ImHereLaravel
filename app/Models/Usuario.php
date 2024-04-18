<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuario';
    protected $fillable = ['id', 'nombre', 'contraseña', 'correo',  'id_perfil', 'fecha', 'sexo', 'coin', 'imagen'];

    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    public function juego()
    {
        return $this->hasMany(Juego::class, 'id_usuario', 'id');
    }
}
