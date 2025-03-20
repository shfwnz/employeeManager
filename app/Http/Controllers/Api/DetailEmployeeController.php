<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class DetailEmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['jobs' => function ($query) {
            $query->with(['division', 'position']);
        }])->get();

        if ($employees->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada karyawan yang ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'List Data Karyawan',
            'data' => $employees
        ]);
    }

    public function show($id)
    {
        $employee = Employee::with(['jobs.division', 'jobs.position'])->find($id);

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Karyawan',
            'data' => $employee
        ]);
    }
}
