<?php

namespace App\Http\Controllers;

use App\Models\Carrito_Compras;
use App\Models\Detalle_Transaccion;
use App\Models\Juego;
use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoComprasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getcarritocomprasAll()
    {
        //get All a todo el equipo
        $carritocompras = Carrito_Compras::all();
        return $carritocompras;
    }

    public function getcarritocompras($id)
    {
        $registro = Carrito_Compras::find($id);
        return $registro;
    }

    public function deletecarritocompras($id)
    {
        $registro = Carrito_Compras::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putcarritocompras(Request $request, $id)
    {
        $registro = Carrito_Compras::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postcarritocompras(Request $request)
    {
        $carrito = null;
        try {
            // 1. Obtener el usuario autenticado
            $usuarioId = Auth::id();
            //Validar al usuario que este logeado

            $context = $request->all();

            // 2. Obtener el token de tarjeta de crédito enviado desde el frontend
            $token = $context['datosTarjeta'];

            // 3. Obtener el carrito del usuario desde el frontend
            $products = $context['productos'];

            // Obtener el monto total del carrito
            $totalAmount = $context['total'];

            // Inicializar la variable para almacenar la cantidad total de monedas compradas
            $totalCoins = 0;

            // Iterar sobre cada producto en el carrito
            foreach ($products as $detalle) {
                // Verificar si el nombre del producto contiene la palabra "OsoMoneda"
                if (strpos($detalle['nombre'], 'OsoMoneda') !== false) {
                    // Obtener la cantidad de monedas del nombre del producto
                    $cantidadMonedas = (int) filter_var($detalle['nombre'], FILTER_SANITIZE_NUMBER_INT);
                    // Sumar la cantidad de monedas al total
                    $totalCoins += $cantidadMonedas;
                }
            }

            // 4. Lógica para generar un pedido (crear un nuevo registro en la base de datos para representar el pedido)

            $carrito = Carrito_Compras::create([
                'id_usuario' => $usuarioId,
                'estado' => 'pendiente',
                'total' => $totalAmount,
            ]);

            foreach ($products as $detalle) {
                Detalle_Transaccion::create([
                    'id_carrito' => $carrito->id,
                    'id_producto' => $detalle['id'],
                    'cantidad' => 1,
                    'precio' => $detalle['precio'],
                ]);
            }

            // 5. Realizar el pago con Stripe utilizando el token de tarjeta
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $charge = \Stripe\Charge::create([
                'amount' => $totalAmount * 100,
                'currency' => 'mxn',
                'source' => $token, // Utilizar el token de tarjeta como fuente de pago
            ]);

            // 6. Actualizar el campo 'coin' del usuario con la cantidad total de monedas compradas
            // Primero, obtén el usuario
            $usuario = Usuario::find($usuarioId);
            // Actualiza el campo 'coin'
            $usuario->update(['coin' => $usuario->coin + $totalCoins]);

            // 7. Confirmar la compra
            $carrito->update(['estado' => 'completado']);

            // 8. Logica para guardar en inventario del juego los productos de la compra

            // Crear detalles de transacción para cada producto en el carrito
            /*foreach ($products as $detalle) {
                // Actualizar el modelo del juego con la nueva información
                $juego = Juego::where('id_usuario', $carrito->id_usuario)->first();

                // Ajusta la lógica según tus necesidades
                $productoInfo = Producto::find($detalle['id']);
                $nueva_informacion = $juego->datos . ', ' . $productoInfo->nombre;
                $nuevaInformacionJson = json_encode($nueva_informacion);

                $juego->update(['datos' => $nuevaInformacionJson]);
            }*/
            // 9. Retornar una respuesta exitosa
            return response()->json(['message' => 'Compra Exitosa'], 200);
        } catch (\Stripe\Exception\CardException $e) {
            //Actualizar la compra a rechadaza
            // Manejar errores de tarjeta rechazada
            $carrito->update(['estado' => 'rechazada']);
            return response()->json(['error' => 'Tarjeta Declinada'], 400);
        } catch (\Exception $e) {
            // Manejar cualquier otro error();
            return response()->json(['error' => 'Error al Procesar: ' . $e->getMessage()], 500);
        }
    }



    public function actualizarCompra(Request $request)
    {
        $carrito = Carrito_Compras::where('id', $request->id)->first();
        //dd($carrito->with("detallesTransaccion")->get());
        if (!$carrito) {
            return response()->json(['error' => 'No hay productos en el carrito.']);
        }
        if ($request->estado == 'comprado') {

            // Crear detalles de transacción para cada producto en el carrito
            foreach ($carrito->detallesTransaccion as $detalle) {
                // Actualizar el modelo del juego con la nueva información
                $juego = Juego::where('id_usuario', $carrito->id_usuario)->first();

                // Ajusta la lógica según tus necesidades
                $productoInfo = Producto::find($detalle['id_producto']);


                $nueva_informacion = $juego->datos . ', ' . $productoInfo->nombre;
                $nuevaInformacionJson = json_encode($nueva_informacion);

                $juego->update(['datos' => $nuevaInformacionJson]);
            }
        }
        //dd($request->estado);


        $carrito->update(['estado' => $request->estado]);

        return response()->json(['message' => 'Estatus actualizado con éxito.']);
    }


    public function checkout(Request $request)
    {
        try {
            // 1. Obtener el usuario autenticado
            $usuarioId = auth()->user();
            //Validar al usuario que este logeado

            $context = $request->all();

            // 2. Obtener el token de tarjeta de crédito enviado desde el frontend
            $token = $context['token'];

            // 3. Obtener el carrito del usuario desde el frontend
            $cartData = json_decode($context['carrito'], true);

            // Obtener los productos y el monto total del carrito
            $products = $cartData['products'];
            $totalAmount = $cartData['total_amount'];

            // 4. Lógica para generar un pedido (crear un nuevo registro en la base de datos para representar el pedido)
            $compra = new Carrito_Compras(/*añadir id del usuario*/);
            $compra->total = $totalAmount;
            // Puedes agregar más campos según sea necesario para tu aplicación
            $compra->save();

            // 5. Asociar los productos del carrito con el pedido
            foreach ($products as $product) {
                Detalle_Transaccion::create([
                    'id_carrito' => $compra->id,
                    'id_producto' => $product['id'],
                    'cantidad' => $product['quantity'],
                    'precio' => $product['precio'], // Asegúrate de proporcionar el valor correcto aquí
                ]);
            }

            // 6. Realizar el pago con Stripe utilizando el token de tarjeta
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $charge = \Stripe\Charge::create([
                'amount' => $totalAmount * 100,
                'currency' => 'usd',
                'source' => $token, // Utilizar el token de tarjeta como fuente de pago
            ]);

            // 7. Confirmar la compra
            $compra->estado = 'completed';
            $compra->save();

            // 8. Logica para guardar en inventario del juego los productos de la compra

            // 9. Retornar una respuesta exitosa con el total del pedido
            return response()->json(['message' => 'Compra Exitosa', 'total_amount' => $totalAmount], 200);
        } catch (\Stripe\Exception\CardException $e) {
            //Actualizar la compra a rechadaza
            // Manejar errores de tarjeta rechazada
            return response()->json(['error' => 'Tarjeta Declinada'], 400);
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            return response()->json(['error' => 'Error al Procesar: ' . $e->getMessage()], 500);
        }
    }
}
