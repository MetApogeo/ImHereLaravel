<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Response;

class ProductoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getproductoAll()
    {
        //get All a todo el Producto
        $producto = Producto::all();
        return $producto;
    }

    public function getproducto($id)
    {
        $registro = Producto::find($id);
        return $registro;
    }

    public function deleteproducto($id)
    {
        $registro = Producto::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putproducto(Request $request, $id)
    {
        $registro = Producto::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postproducto(Request $request)
    {
        try {

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $registro = Producto::create([
                'nombre' => $context['nombre'],
                'descripcion' => $context['descripcion'],
                'precio' => $context['precio'],
                'inventario' => $context['inventario'],
                'exclusivo' => $context['exclusivo'],
                'imagen' => $context['imagen'],
            ]);
            return response()->json(['success' => true, 'data' => $registro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function mostrar_foto($nombre_foto)
    {
        $path = storage_path('app/public/imagenes/' . $nombre_foto);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
