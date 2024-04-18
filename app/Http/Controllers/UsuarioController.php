<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Juego;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;


class UsuarioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getusuarioAll()
    {
        //get All a todo el Usuario
        $usuario = Usuario::with('juego')->get();
        return $usuario;
    }

    public function getusuario($id)
    {
        $registro = Usuario::with('juego')->find($id);
        return $registro;
    }

    public function deleteusuario($id)
    {
        $registro = Usuario::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }
        $registro->delete();
        return response()->json(['Task deleted successfully.']);
        //return $registro;
    }

    public function putusuario(Request $request, $id)
    {
        $registro = Usuario::find($id);
        if (is_null($registro)) {
            return response()->json('Data not found', 404);
        }

        // Verificar si se ha enviado una imagen en la solicitud

        $registro->imagen = $request->imagen;
        // Actualizar otros campos si se han enviado en la solicitud
        $registro->save();

        return response()->json(['Task updated successfully.']);
    }





    public function postusuario(Request $request)
    {
        try {

            // Verificar si se ha cargado una imagen en la solicitud
            if ($request->hasFile('imagen')) {
                // Obtener la imagen de la solicitud
                $imagen = $request->file('imagen');

                // Guardar la imagen en el servidor
                $rutaImagen = $imagen->store('public/imagenes');
            } else {
                // Si no se ha cargado una imagen, establecer la ruta de imagen como nula o una ruta predeterminada
                $rutaImagen = null; // o puedes establecer una ruta predeterminada
            }

            $context = $request->all();
            //$datos = ['numero' => $request->input('numero')];

            $fecha = Carbon::parse($context['fecha'])->toDateString();
            $registro = Usuario::create([
                'nombre' => $context['nombre'],
                'contraseña' => md5($context['contraseña']),
                'correo' => $context['correo'],
                'id_perfil' => $context['id_perfil'],
                'fecha' => $fecha,
                'sexo' => $context['sexo'],
                'coin' => 0,
                'imagen' => $rutaImagen,
            ]);

            $datosIniciales = ['puntaje' => 0, 'posicion' => 0];
            $juego = Juego::create([
                'id_usuario' => $registro->id,
                'datos' => json_encode($datosIniciales)
            ]);

            return response()->json(['success' => true, 'data' => $registro . $juego]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->where("contraseña", md5($request->contraseña))->first();

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Credenciales incorrectas'], 401);
        }

        // Aquí podrías agregar cualquier lógica adicional de autenticación que necesites.

        $token = $usuario->createToken('nombre-del-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function uploadImagen(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            // Lógica para guardar la imagen en el servidor
            $rutaImagen = $imagen->store('public/imagenes');

            // Devolver la URL de la imagen almacenada
            return response()->json(['url' => str_replace('public/imagenes/', '', $rutaImagen)]);
        } else {
            return response()->json(['error' => 'No se ha enviado ninguna imagen'], 400);
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
