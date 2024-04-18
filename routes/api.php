<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoComprasController;
use App\Http\Controllers\DetalleTransaccionController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PerfilPermisoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// TODO      Carrito Compras
Route::post('/carritocompras', [CarritoComprasController::class, 'postcarritocompras'])->middleware('auth:sanctum');
Route::get('/carritocompras', [CarritoComprasController::class, 'getcarritocomprasAll']);
Route::get('/carritocompras/{id}', [CarritoComprasController::class, 'getcarritocompras']);
Route::put('/carritocompras/{id}', [CarritoComprasController::class, 'putcarritocompras']);
Route::delete('/carritocompras/{id}', [CarritoComprasController::class, 'deletecarritocompras']);
Route::post('/checkout', [CarritoComprasController::class, 'checkout']);

//* ActualizarCompra
Route::put('/carritocompras/actualizarcompra/{id}', [CarritoComprasController::class, 'actualizarCompra'])->middleware('auth:sanctum');


// TODO      Detalle Transaccion
Route::post('/detalletransaccion', [DetalleTransaccionController::class, 'postdetalletransaccion']);
Route::get('/detalletransaccion', [DetalleTransaccionController::class, 'getdetalletransaccionAll']);
Route::get('/detalletransaccion/{id}', [DetalleTransaccionController::class, 'getdetalletransaccion']);
Route::put('/detalletransaccion/{id}', [DetalleTransaccionController::class, 'putdetalletransaccion']);
Route::delete('/detalletransaccion/{id}', [DetalleTransaccionController::class, 'deletedetalletransaccion']);

// TODO      Juego
Route::post('/juego', [JuegoController::class, 'postjuego']);
Route::get('/juego', [JuegoController::class, 'getjuegoAll']);
Route::get('/juego/{id}', [JuegoController::class, 'getjuego']);
Route::put('/juego/{id}', [JuegoController::class, 'putjuego']);
Route::delete('/juego/{id}', [JuegoController::class, 'deletejuego']);

// TODO      Perfil
Route::post('/perfil', [PerfilController::class, 'postperfil']);
Route::get('/perfil', [PerfilController::class, 'getperfilAll']);
Route::get('/perfil/{id}', [PerfilController::class, 'getperfil']);
Route::put('/perfil/{id}', [PerfilController::class, 'putperfil']);
Route::delete('/perfil/{id}', [PerfilController::class, 'deleteperfil']);

// TODO      Perfil Permiso
Route::post('/perfilpermiso', [PerfilPermisoController::class, 'postperfilpermiso']);
Route::get('/perfilpermiso', [PerfilPermisoController::class, 'getperfilpermisoAll']);
Route::get('/perfilpermiso/{id}', [PerfilPermisoController::class, 'getperfilpermiso']);
Route::put('/perfilpermiso/{id}', [PerfilPermisoController::class, 'putperfilpermiso']);
Route::delete('/perfilpermiso/{id}', [PerfilPermisoController::class, 'deleteperfilpermiso']);

// TODO      Permiso
Route::post('/permiso', [PermisoController::class, 'postpermiso']);
Route::get('/permiso', [PermisoController::class, 'getpermisoAll']);
Route::get('/permiso/{id}', [PermisoController::class, 'getpermiso']);
Route::put('/permiso/{id}', [PermisoController::class, 'putpermiso']);
Route::delete('/permiso/{id}', [PermisoController::class, 'deletepermiso']);

// TODO      Producto
Route::post('/producto', [ProductoController::class, 'postproducto']);
Route::get('/producto', [ProductoController::class, 'getproductoAll']);
Route::get('/producto/{id}', [ProductoController::class, 'getproducto']);
Route::put('/producto/{id}', [ProductoController::class, 'putproducto']);
Route::delete('/producto/{id}', [ProductoController::class, 'deleteproducto']);

// TODO      Usuario
Route::post('/usuario', [UsuarioController::class, 'postusuario']);
Route::get('/usuario', [UsuarioController::class, 'getusuarioAll']);
Route::get('/usuario/{id}', [UsuarioController::class, 'getusuario']);
Route::put('/usuario/{id}', [UsuarioController::class, 'putusuario']);
Route::delete('/usuario/{id}', [UsuarioController::class, 'deleteusuario']);

//*LOGIN
Route::post('/login', [UsuarioController::class, 'login'])->name('login');

//* UpLoad Image
Route::post('/upload-imagen', [UsuarioController::class, 'uploadImagen']);
// ? FOTOS
Route::get('/usuario/foto/{nombre_foto}', [UsuarioController::class, 'mostrar_foto']);
Route::get('/producto/foto/{nombre_foto}', [UsuarioController::class, 'mostrar_foto']);
