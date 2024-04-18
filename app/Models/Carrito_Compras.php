<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito_Compras extends Model
{
    protected $table = 'carrito_compras';
    protected $fillable = ['id', 'id_usuario', 'estado', 'total'];

    public function detallesTransaccion()
    {
        return $this->hasMany(Detalle_Transaccion::class, 'id_carrito', 'id');
    }
}
