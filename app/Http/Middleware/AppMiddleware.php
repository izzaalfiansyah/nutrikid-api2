<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appKey = env('APP_API_KEY');
        $currentKey = $request->headers->get('X-App-Key');

        if ($appKey !== $currentKey) {
            return response()->json([
                'success' => false,
                'message' => 'Access Forbidden',
            ], 403);
        }

        $bearerToken = $request->headers->get('Authorization');

        try {
            $token = str_replace("Bearer ", "", $bearerToken);

            $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $user = User::find($payload->id);

            auth()->guard()->login($user);
        } catch (\Exception $e) {
            auth()->guard()->logout();
            // do nothing
        }

        return $next($request);
    }
}
