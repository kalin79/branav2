<?php

namespace App\Http\Controllers\Api\V1;

use App\Mail\BienvenidaParticipanteMail;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Participante;
use App\Models\Sale;
use App\Models\Sorteo;
use App\Models\UsuarioGloria;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ParticipanteController extends Controller
{
    use ApiResponser;
    public function store(Request $request)
    {
        //dd(1);
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            //'apellido_materno' => 'required|string|max:255',
            'email' => 'required|email|unique:clientes',
            //'nro_documento' => 'required|unique:usuarios_gloria',
            'password' => 'required|string|min:6',
            //'tyc' => 'required'
        ]);

        // Si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar el participante
        $participante = Clientes::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => strtolower($request->email),
            /*'apellido_materno' => $request->apellido_materno,
            'celular' => $request->celular,

            'nro_documento' => $request->nro_documento,
            'tipo_documento' => $request->tipo_documento,*/
            'password' => Hash::make($request->password),
            //'tyc' => $request->tyc,
            //'fecha_nacimiento' => $request->birhtday,
        ]);

        registrarLogFront($participante->email,'registro', 'El usuario se registró correctamente.');
        // Retornar respuesta de éxito
        return response()->json([
            'status' => 'success',
            'message' => 'Usuario registrado con éxito',
            'data' => $participante
        ], 201);
    }

    public function update(Request $request)
    {
        //dd(1);
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'email' => 'required|email',
            'dni' => 'required',
        ]);

        // Si la validación falla
        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Guardar el participante
        $participante = Clientes::find($request->id)->update([
            'nombres' => $request->nombres,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'celular' => $request->celular,
            'email' => strtolower($request->email),
            'nro_documento' => $request->nro_documento,
            'tipo_documento' => $request->tipo_documento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        // Retornar respuesta de éxito
        return response()->json([
            'status' => 'success',
            'message' => 'Participante actualizado con éxito',
            'data' => $participante
        ], 201);
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            registrarLogFront($request->email,"errors",$validator->errors());
            return response()->json($validator->errors(), 422);
        }

        $email = strtolower($request->email);
        $user = Clientes::whereRaw('LOWER(email) = ?', [$email])->first();

        if (!$user) {
            registrarLogFront($email,"login_fallido",'Credenciales incorrectas');
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // Verificar si el usuario está bloqueado
        if ($user->locked_at) {
            registrarLogFront($email,"login_fallido",'Usuario bloqueado por múltiples intentos fallidos. Contacte al administrador.');
            return response()->json([
                'status' => 'error',
                'message' => 'Usuario bloqueado por múltiples intentos fallidos. Contacte al administrador.'
            ], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            /*$user->login_attempts += 1;

            if ($user->login_attempts >= 3) {
                $user->locked_at = now();
            }*/

            //$user->save();
           /* registrarLogFront($email,"login_fallido",$user->locked_at
                ? 'Usuario bloqueado por múltiples intentos fallidos.'
                : 'Credenciales incorrectas');*/

            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        // Autenticación exitosa
        //$user->login_attempts = 0;
        //$user->locked_at = null;
        //$user->save();
        registrarLogFront($email,"login_exitoso",'Inicio de sesión exitoso.');
        $token = auth()->guard('api')->login($user);
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        registrarLogFront(auth()->guard('api')->user()->email,"Logout",'Sesión cerrada exitosamente');
        auth('api')->invalidate(auth('api')->getToken());
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function me()
    {
        //dd(11);
        return response()->json(auth()->guard('api')->user());
    }

    public function refresh()
    {
        // dd(11);
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'success',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        // Validar los datos recibidos
        /*$validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buscar al participante
        $participante = Participante::find($id);

        if (!$participante) {
            return response()->json([
                'status' => 'error',
                'message' => 'Participante no encontrado.',
            ], 404);
        }

        // Actualizar la contraseña
        $participante->password = Hash::make($validatedData['password']);
        $participante->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Contraseña actualizada con éxito.',
        ], 200);*/
    }
}
