<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Student;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index(Request $request)
    {
        $query = Measurement::query();

        $query->whereNull('deleted_at');

        $school_id = $request->school_id;
        $student_id = $request->student_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $limit = $request->limit ?? 20;
        $page = $request->page ?? 1;
        $skip = $limit * ($page - 1);

        if (!$school_id && auth()->guard()->user()->role != "admin") {
            $school_id = auth()->guard()->user()->school_id;
        }

        if ($school_id) {
            $query->where('students.school_id', $school_id);
        }

        if ($student_id) {
            $query->where('student_id', $student_id);
        }

        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date, $end_date]);
        }

        $total = $query->count();

        $measurements = $query->take($limit)->skip($skip)->orderBy('created_at', 'desc')->get();

        return [
            'success' => true,
            'message' => "pengukuran berhasil diambil",
            'data' => [
                'total' => $total,
                'measurements' => $measurements,
            ]
        ];
    }

    public function show($id)
    {
        $measurement = Measurement::find($id);

        if (!$measurement) {
            return response()->json([
                'success' => false,
                'message' => "pengukuran tidak ditemukan",
            ], 404);
        }

        $measurement->measurement = Measurement::where('measurement_id', $id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();

        return [
            'success' => true,
            'message' => "pengukuran berhasil diambil",
            'data' => [
                'measurement' => $measurement,
            ]
        ];
    }

    public function store(Request $request)
    {
        try {
            $student = Student::find($request->student_id);

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => "siswa tidak ditemukan",
                ], 404);
            }

            $student_height = $request->student_height;
            $student_weight = $request->student_weight;
            $created_at = $request->created_at;

            $result = calculateResult($student_height, $student_weight, $student->birth_date, $student->gender, $created_at);

            $data = [
                'student_id' => $student->id,
                'student_age' => $result['age'],
                'student_age_month' => $result['student_age_month'],
                'student_height' => $student_height,
                'student_weight' => $student_weight,
                'student_bmi' => $result['bmi'],
                'creator_id' => auth()->guard()->user()->id,
            ];

            if ($created_at) {
                $data['created_at'] = $created_at;
            }

            Measurement::create($data);

            return response()->json([
                'success' => true,
                'message' => "pengukuran berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal menambahkan pengukuran",
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $measurement = Measurement::find($id);

            $student = $measurement->student;
            $student_height = $request->student_height;
            $student_weight = $request->student_weight;
            $created_at = $request->created_at;

            $result = calculateResult($student_height, $student_weight, $student->birth_date, $student->gender, $created_at);

            $data = [
                'student_age' => $result['age'],
                'student_age_month' => $result['student_age_month'],
                'student_height' => $student_height,
                'student_weight' => $student_weight,
                'student_bmi' => $result['bmi'],
                'creator_id' => auth()->guard()->user()->id,
            ];

            if ($created_at) {
                $data['created_at'] = $created_at;
            }

            $measurement->update($data);

            return response()->json([
                'success' => true,
                'message' => "pengukuran berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit pengukuran",
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $measurement = Measurement::find($id);
            $measurement->update([
                'deleted_at' => time(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "pengukuran berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal hapus pengukuran",
            ], 422);
        }
    }

    public function calculate(Request $req)
    {
        try {
            $result = calculateResult($req->student_height, $req->student_weight, $req->birth_date, $req->gender, $req->created_at);

            return response()->json([
                'success' => true,
                'message' => "status kesehatan berhasil dihitung",
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "gagal menghitung status kesehatan",
            ], 422);
        }
    }

    public function getDefaultZScore(Request $req)
    {
        $gender = $req->gender;

        if (!$gender) {
            return response()->json([
                'success' => false,
                'message' => "gender harus diisi",
            ], 422);
        }

        $z_scores = $gender == "l" ? male_z_scores() : female_z_scores();

        return response()->json([
            'success' => true,
            'message' => "z score berhasil didapatkan",
            'data' => [
                'z_scores' => $z_scores,
            ],
        ]);
    }
}
