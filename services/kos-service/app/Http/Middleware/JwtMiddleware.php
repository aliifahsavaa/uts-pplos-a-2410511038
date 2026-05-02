<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader) {
            return response()->json(['message' => 'Token Tidak Ditemukan.'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $request->merge(['user' => (array) $decoded]);
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token Tidak Valid atau Kadaluwarsa.'], 403);
        }
    }
}
