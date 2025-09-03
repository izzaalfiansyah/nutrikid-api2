<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        $query->whereNull('deleted_at');

        $school_id = $request->school_id;
        $role = $request->role;
        $search = $request->search;
        $limit = $request->limit ?? 20;
        $page = $request->page ?? 1;
        $skip = $limit * ($page - 1);

        if (!$school_id && auth()->guard()->user()->role != "admin") {
            $school_id = auth()->guard()->user()->school_id;
        }

        if ($school_id) {
            $query->where('school_id', $school_id);
        }

        if ($role) {
            $query->where('role', $role);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%')->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();

        $users = $query->take($limit)->skip($skip)->orderBy('name', 'asc')->get();

        return [
            'success' => true,
            'message' => "pengguna berhasil diambil",
            'data' => [
                'total' => $total,
                'users' => $users,
            ]
        ];
    }

    public function show($id)
    {
        $user = User::find($id);

        return [
            'success' => true,
            'message' => "pengguna berhasil diambil",
            'data' => [
                'user' => $user,
            ]
        ];
    }

    public function store(Request $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password,
                'school_id' => $request->school_id,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => "pengguna berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal menambahkan pengguna",
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'school_id' => $request->school_id,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            return response()->json([
                'success' => true,
                'message' => "pengguna berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit pengguna",
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::find($id);
            $user->update([
                'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'success' => true,
                'message' => "pengguna berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal hapus pengguna",
            ], 422);
        }
    }

    public function changePassword(Request $req, $id)
    {
        try {
            $user = User::find($id);
            $auth = auth()->guard()->user();

            if ($auth->role != 'admin' && $auth->id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => "Anda tidak memiliki hak untuk mengedit password",
                ], 401);
            }

            $user->update([
                'password' => $req->password,
            ]);

            return response()->json([
                'success' => true,
                'message' => "password berhasil diedit",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "gagal mengedit password",
            ], 422);
        }
    }
}
