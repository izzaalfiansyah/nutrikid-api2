<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\MeasurementSuggestion;
use Illuminate\Http\Request;

class MeasurementSuggestionController extends Controller
{
    public function index(Request $request, $measurementId = null)
    {
        $query = MeasurementSuggestion::query();

        $query->whereNull('deleted_at');

        $measurement_id = $measurementId ?? $request->school_id;
        $limit = $request->limit ?? 20;
        $page = $request->page ?? 1;
        $skip = $limit * ($page - 1);

        if ($measurement_id) {
            $query->where('measurement_id', $measurement_id);
        }

        $total = $query->count();

        $suggestions = $query->take($limit)->skip($skip)->get();

        return [
            'success' => true,
            'message' => "saran berhasil diambil",
            'data' => [
                'total' => $total,
                'suggestions' => $suggestions,
            ]
        ];
    }

    public function store(Request $request)
    {
        try {
            MeasurementSuggestion::create([
                'advice' => $request->advice,
                'creator_id' => $request->creator_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "saran berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal menambahkan saran",
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $suggestion = MeasurementSuggestion::find($id);
            $suggestion->update([
                'advice' => $request->advice,
            ]);

            return response()->json([
                'success' => true,
                'message' => "saran berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit saran",
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $suggestion = MeasurementSuggestion::find($id);
            $suggestion->delete();

            return response()->json([
                'success' => true,
                'message' => "saran berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal hapus saran",
            ], 422);
        }
    }
}
