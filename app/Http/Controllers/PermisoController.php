<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getpermisoAll()
    {
        //get All a todo el Permiso
        $permiso = Permiso::all();
        return $permiso;
    }

    public function getpermiso($id)
    {
        $registro = Permiso::find($id);
        return $registro;
    }

    public function deletepermiso($id)
    {
        $registro = Permiso::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putpermiso(Request $request, $id)
    {
        $registro = Permiso::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postpermiso(Request $request)
    {
        try {

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $registro = Permiso::create([
                'clave_permiso' => $context['clave_permiso'],
                'nombre_permiso' => $context['nombre_permiso'],
            ]);
            return response()->json(['success' => true, 'data' => $registro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
