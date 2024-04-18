<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getperfilAll()
    {
        //get All a todo el Perfil
        $perfil = Perfil::all();
        return $perfil;
    }

    public function getperfilById($id)
    {
        $registro = Perfil::find($id);
        return $registro;
    }

    public function deleteperfilById($id)
    {
        $registro = Perfil::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putModificarperfil(Request $request, $id)
    {
        $registro = Perfil::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->update($request->all());
        $registro->save();
        return response()->json(['Task updated successfully.']);
        //return $registro;
    }

    public function postAddperfil(Request $request)
    {
        try {

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $registro = Perfil::create([
                'nombre' => $context['nombre'],
            ]);
            return response()->json(['success' => true, 'data' => $registro]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
