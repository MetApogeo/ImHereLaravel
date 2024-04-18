<?php

namespace App\Http\Controllers;

use App\Models\Detalle_Transaccion;
use Illuminate\Http\Request;

class DetalleTransaccionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getdetalletransaccionAll()
    {
        //get All a todo el equipo
        $detalletransaccion = Detalle_Transaccion::all();
        return $detalletransaccion;
    }

    public function getdetalletransaccion($id)
    {
        $registro = Detalle_Transaccion::find($id);
        return $registro;
    }

    public function deletedetalletransaccion($id)
    {
        $registro = Detalle_Transaccion::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putdetalletransaccion(Request $request, $id)
    {
        $registro = Detalle_Transaccion::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postdetalletransaccion(Request $request)
    {
        try {

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $registro = Detalle_Transaccion::create([
                'id_transaccion ' => $context['id_transaccion '],
                'id_producto' => $context['id_producto'],
                'cantidad' => $context['cantidad'],
                'precio' => $context['precio']
            ]);
            return response()->json(['success' => true, 'data' => $registro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
