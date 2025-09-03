<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        $query->whereNull('deleted_at');

        $school_id = $request->school_id;
        $gender = $request->gender;
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

        if ($gender) {
            $query->where('gender', $gender);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%')->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count();

        $students = $query->take($limit)->skip($skip)->orderBy('name', 'asc')->get();

        return [
            'success' => true,
            'message' => "siswa berhasil diambil",
            'data' => [
                'total' => $total,
                'students' => $students,
            ]
        ];
    }

    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => "siswa tidak ditemukan",
            ], 404);
        }

        $student->measurement = Measurement::where('student_id', $id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();

        return [
            'success' => true,
            'message' => "siswa berhasil diambil",
            'data' => [
                'student' => $student,
            ]
        ];
    }

    public function store(Request $request)
    {
        try {
            Student::create([
                'name' => $request->name,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'school_id' => $request->school_id,
                'birth_date' => $request->birth_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => "siswa berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal menambahkan siswa",
            ], 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $student = Student::find($id);
            $student->update([
                'name' => $request->name,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'school_id' => $request->school_id,
                'birth_date' => $request->birth_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => "siswa berhasil diedit",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal edit siswa",
            ], 422);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $student = Student::find($id);
            $student->update([
                'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return response()->json([
                'success' => true,
                'message' => "siswa berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "gagal hapus siswa",
            ], 422);
        }
    }
}
