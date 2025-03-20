<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Resources\BaseResource;
use Illuminate\Support\Facades\DB;


class DetailEmployeeController extends Controller
{
    public function getEmployees(Request $request)
    {
        $divisionFilter = $request->input('divisi_id');
        $perPage = $request->input('per_page', 10);

        $query = Employee::with(['jobs.division', 'jobs.position'])
            ->when($divisionFilter, function ($q) use ($divisionFilter) {
                return $q->whereHas('jobs.division', function ($q) use ($divisionFilter) {
                    $q->where('id', $divisionFilter);
                });
            });

        $employees = $query->paginate($perPage);

        return new BaseResource(
            true,
            'Daftar karyawan',
            [
                'items' => $employees->items(),
                'pagination' => [
                    'total' => $employees->total(),
                    'current_page' => $employees->currentPage(),
                    'per_page' => $employees->perPage(),
                ]
            ]
        );
    }

    public function getDivisions()
    {
        $divisions = DB::table('divisi')->select('id', 'nama_divisi as division_name')->get();

        return response()->json(['data' => $divisions]);
    }

    public function getStatistics(Request $request)
    {
        $divisionFilter = $request->input('divisi_id');

        $query = Employee::when($divisionFilter, function ($q) use ($divisionFilter) {
            return $q->whereHas('jobs.division', function ($q) use ($divisionFilter) {
                $q->where('id', $divisionFilter);
            });
        });

        return response()->json([
            'totalEmployees' => $query->count(),
            'activeEmployees' => $query->where('status', 'Aktif')->count(),
            'inactiveEmployees' => $query->where('status', 'Nonaktif')->count(),
        ]);
    }

    public function getEmployeesByDivision()
    {
        $employeesByDivision = DB::table('pekerjaan')
            ->join('divisi', 'pekerjaan.divisi_id', '=', 'divisi.id')
            ->join('karyawan', 'pekerjaan.karyawan_id', '=', 'karyawan.id')
            ->select('divisi.nama_divisi as name', DB::raw('COUNT(karyawan.id) as count'))
            ->groupBy('divisi.nama_divisi')
            ->get();

        return response()->json(['data' => $employeesByDivision]);
    }
}
