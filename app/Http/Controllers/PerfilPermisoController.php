<?php

namespace App\Http\Controllers;

use App\Models\Perfil_Permiso;
use Illuminate\Http\Request;

class PerfilPermisoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getperfilpermisoAll()
    {
        //get All a todo el Perfil_Permiso
        $Perfil_Permisos = Perfil_Permiso::all();
        return $Perfil_Permisos;
    }

    public function getperfilpermiso($id)
    {
        $registro = Perfil_Permiso::find($id);
        return $registro;
    }

    public function deleteperfilpermiso($id)
    {
        $registro = Perfil_Permiso::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putperfilpermiso(Request $request, $id)
    {
        $registro = Perfil_Permiso::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postperfilpermiso(Request $request)
    {
        try {

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $registro = Perfil_Permiso::create([
                'id_perfil ' => $context['id_perfil '],
                'id_permisos ' => $context['id_permisos '],
            ]);
            return response()->json(['success' => true, 'data' => $registro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
