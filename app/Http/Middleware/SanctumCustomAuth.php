<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class SanctumCustomAuth
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard('sanctum')->check()) {
            return $next($request);
        }

        $response = [
            "status" => 401,
            "message" => "Unauthenticated!",
            "data" => [],
            "success" => false
        ];

        return response()->json($response, Response::HTTP_UNAUTHORIZED);
    }
}
