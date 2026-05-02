<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        
        if (!$authHeader) {
            return response()->json(['message' => 'Token Tidak Ditemukan.'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);
        
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return response()->json(['message' => 'Token Tidak Valid.'], 403);
        }

        $payload = json_decode(base64_decode($parts[1]), true);
        
        if (!$payload || !isset($payload['exp']) || $payload['exp'] < time()) {
            return response()->json(['message' => 'Token Kadaluwarsa.'], 403);
        }

        $request->merge(['user' => $payload]);
        return $next($request);
    }
}