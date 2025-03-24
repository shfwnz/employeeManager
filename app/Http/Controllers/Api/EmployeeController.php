<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['jobs', 'division', 'position']);

        if ($request->has('division_id')) {
            $query->whereHas('jobs', function ($q) use ($request) {
                $q->where('divisi_id', $request->division_id);
            });
        }

        $employees = $query->latest()->paginate(5);
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

        // Handle upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('uploads/karyawan', 'public');
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
            'foto' => $fotoPath,
            'status' => $request->status ?? 'Aktif'
        ]);

        return new BaseResource(true, 'Data karyawan ditambahkan', $employee);
    }

    public function show($id)
    {
        $employee = Employee::with(['jobs', 'division', 'position'])->find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail Karyawan', $employee);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nik' => "sometimes|required|unique:karyawan,nik,$id",
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'tempat_lahir' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'jenis_kelamin' => 'sometimes|required|in:Laki-laki,Perempuan',
            'alamat' => 'sometimes|required|string',
            'telepon' => 'sometimes|required|string|max:15',
            'email' => "sometimes|required|email|unique:karyawan,email,$id",
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'nullable|in:Aktif,Nonaktif'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Handle upload foto baru
        if ($request->hasFile('foto')) {
            if ($employee->foto) {
                Storage::disk('public')->delete($employee->foto);
            }
            $employee->foto = $request->file('foto')->store('uploads/karyawan', 'public');
        }

        $employee->update($request->except('foto'));

        return new BaseResource(true, 'Data Karyawan berhasil diupdate', $employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Karyawan tidak ditemukan'], 404);
        }

        if ($employee->foto) {
            Storage::disk('public')->delete($employee->foto);
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
            'division_id' => 'required|exists:divisi,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employees = Employee::whereHas('jobs', function ($query) use ($request) {
            $query->where('divisi_id', $request->division_id);
        })->count();

        return new BaseResource(true, 'Jumlah karyawan berdasarkan divisi', $employees);
    }
}
