<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('username', $request->username)->first();

            if (!$user) {
                throw new \Exception("user not found");
            }

            $isValid = Hash::check($request->password, $user->password);

            if (!$isValid) {
                throw new \Exception("invalid password");
            }

            $payload = ['id' => $user->id];

            $access_token = JWT::encode([...$payload, 'exp' => time() + (60 * 60 * 7)], env('JWT_SECRET'), 'HS256');
            $refresh_token = JWT::encode([...$payload, 'exp' => time() + (60 * 60 * 30)], env('JWT_SECRET'), 'HS256');

            return response()->json([
                'success' => true,
                'message' => "berhasil login",
                'data' => [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Username atau password salah",
            ], 401);
        }
    }

    public function profile()
    {
        return [
            'success' => true,
            'message' => "Profil berhasil diambil",
            'data' => [
                'profile' => auth()->guard()->user(),
            ],
        ];
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = auth()->guard()->user();
            $user = User::find($user->id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'success' => true,
                'message' => "profil berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit profil",
            ], 422);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = auth()->guard()->user();
            $user = User::find($user->id);
            $user->update([
                'password' => $request->password,
            ]);

            return response()->json([
                'success' => true,
                'message' => "password berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit password",
            ], 422);
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            JWT::decode($request->refresh_token, new Key(env('JWT_SECRET'), 'HS256'));
            $user = auth()->guard()->user();

            $payload = ['id' => $user->id];

            $access_token = JWT::encode([...$payload, 'exp' => time() + (60 * 60 * 7)], env('JWT_SECRET'), 'HS256');
            $refresh_token = JWT::encode([...$payload, 'exp' => time() + (60 * 60 * 30)], env('JWT_SECRET'), 'HS256');

            return response()->json([
                'success' => true,
                'message' => "refresh token berhasil",
                'data' => [
                    'access_token' => $access_token,
                    'refresh_token' => $refresh_token,
                ],
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal refresh token",
            ], 422);
        }
    }

    public function logout()
    {
        auth()->guard()->logout();

        return [
            'success' => true,
            'message' => "logout berhasil",
        ];
    }
}
