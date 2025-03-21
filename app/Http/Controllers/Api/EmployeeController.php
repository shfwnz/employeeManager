<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['division', 'position'])->latest()->paginate(5);

        return new BaseResource(true, 'Daftar karyawan', $employees);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:karyawan,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:karyawan,email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:Aktif,Nonaktif'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee = Employee::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'foto' => $request->foto,
            'status' => $request->status ?? 'Aktif'
        ]);

        return new BaseResource(true, 'Data employee ditambahkan', $employee);
    }

    public function show($id)
    {
        $employee = Employee::with(['division', 'position'])->find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail Karyawan', $employee);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'sometimes|required|unique:karyawan,nik,' . $id,
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'tempat_lahir' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
            'alamat' => 'sometimes|required|string',
            'telepon' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|email|unique:karyawan,email,' . $id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:Aktif,Nonaktif'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        $employee->update($request->all());

        return new BaseResource(true, 'Data Karyawan berhasil diupdate', $employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }
        $employee->delete();

        return new BaseResource(true, 'Data Karyawan berhasil dihapus', $employee);
    }

    public function getTotalEmployees()
    {
        $totalEmployees = Employee::count();
        return new BaseResource(true, 'Total jumlah karyawan', $totalEmployees);
    }
    public function getEmployeesByStatus()
    {
        $activeEmployees = Employee::where('status', 'Aktif')->count();
        $inactiveEmployees = Employee::where('status', 'Nonaktif')->count();

        return new BaseResource(true, 'Jumlah karyawan berdasarkan status', [
            'Aktif' => $activeEmployees,
            'Nonaktif' => $inactiveEmployees
        ]);
    }

    public function getEmployeesByDivision(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'division_id' => 'required|exists:divisions,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $divisionId = $request->division_id;
        $employeesCount = Employee::where('division_id', $divisionId)->count();

        return new BaseResource(true, 'Jumlah karyawan berdasarkan divisi', $employeesCount);
    }
}
