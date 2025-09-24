<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Participante;

use Illuminate\Support\Facades\Hash;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Tymon\JWTAuth\Facades\JWTAuth;
class ClientController  extends Controller
{
    use ApiResponser;

    public function authenticate(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Intentar autenticar al usuario
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Credenciales válidas',
            'token_type'=>'Bearer',
            'access_token' => $token,
            'expires_in' => auth()->guard('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }

    public function logout()
    {
        auth('api')->invalidate(auth('api')->getToken());
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    public function me()
    {
        //dd(11);
        return response()->json(auth('api')->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



}
