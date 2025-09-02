<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::whereNull('deleted_at')->get();

        return [
            'success' => true,
            'message' => "data berhasil diambil",
            'data' => [
                'schools' => $schools,
            ],
        ];
    }

    public function store(Request $request)
    {
        try {
            School::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Sekolah berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menambahkan sekolah",
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $school = School::find($id);
            $school->update([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Sekolah berhasil diedit",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Gagal edit sekolah",
            ], 422);
        }
    }

    public function destroy($id)
    {
        try {
            $school = School::find($id);
            $school->update([
                'deleted_at' => time(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Sekolah berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Gagal hapus sekolah",
            ], 422);
        }
    }
}
