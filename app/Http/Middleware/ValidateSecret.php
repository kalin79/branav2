<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSecret
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secret = $request->header('Authorization-secret');

        // Aquí defines el "secret" que validará el acceso
        $validSecret = env('API_SECRET_KEY');

        if ($secret !== $validSecret) {
            registrarLogFront("","Unauthorized","Unauthorized");
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
