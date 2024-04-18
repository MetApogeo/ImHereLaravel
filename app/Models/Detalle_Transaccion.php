<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Transaccion extends Model
{
    protected $table = 'detalle_transaccion';
    protected $fillable = ['id', 'id_producto', 'cantidad', 'precio', 'id_carrito'];

    public function carritoCompras()
    {
        return $this->belongsTo(Carrito_Compras::class, 'id_carrito', 'id');
    }
}
