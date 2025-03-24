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
    // Get employees list
    public function index(Request $request)
    {
        $query = Employee::select(
            'karyawan.id',
            'karyawan.nik',
            'karyawan.nama_lengkap',
            'karyawan.email',
            'karyawan.telepon',
            'karyawan.alamat',
            'karyawan.status',
            'divisi.nama_divisi',
            'jabatan.nama_jabatan',
            'pekerjaan.tanggal_bergabung'
        )
            ->leftJoin('pekerjaan', 'karyawan.id', '=', 'pekerjaan.karyawan_id')
            ->leftJoin('divisi', 'pekerjaan.divisi_id', '=', 'divisi.id')
            ->leftJoin('jabatan', 'pekerjaan.jabatan_id', '=', 'jabatan.id');

        // Filter by division
        if ($request->has('division_id')) {
            $query->where('pekerjaan.divisi_id', $request->division_id);
        }

        return new BaseResource(true, 'Employee list', $query->paginate(5));
    }

    // add new employee
    public function store(Request $request)
    {
        // Validate input
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

        // Validation failed
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload photo
        $fotoPath = $request->hasFile('foto') ? $request->file('foto')->store('uploads/karyawan', 'public') : null;

        // Create employee
        $employee = Employee::create(array_merge($request->all(), ['foto' => $fotoPath, 'status' => $request->status ?? 'Aktif']));

        return new BaseResource(true, 'Employee added', $employee);
    }

    // Get employee by ID
    public function show($id)
    {
        $employee = Employee::with(['jobs', 'division', 'position'])->find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        return new BaseResource(true, 'Employee details', $employee);
    }

    // Update employee by ID
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Validate input
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

        // Validation failed
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Upload new photo
        if ($request->hasFile('foto')) {
            if ($employee->foto) {
                Storage::disk('public')->delete($employee->foto);
            }
            $employee->foto = $request->file('foto')->store('uploads/karyawan', 'public');
        }

        // Update data
        $employee->update($request->except('foto'));

        return new BaseResource(true, 'Employee updated', $employee);
    }

    // Delete employee by ID
    public function destroy($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        // Delete photo if exists
        if ($employee->foto) {
            Storage::disk('public')->delete($employee->foto);
        }

        // Delete employee
        $employee->delete();
        return new BaseResource(true, 'Employee deleted', $employee);
    }

    // Get total employees
    public function getTotalEmployees()
    {
        $totalEmployees = Employee::count();
        return new BaseResource(true, 'Total employees', $totalEmployees);
    }

    // Get employees by status
    public function getEmployeesByStatus()
    {
        $activeEmployees = Employee::where('status', 'Aktif')->count();
        $inactiveEmployees = Employee::where('status', 'Nonaktif')->count();

        return new BaseResource(true, 'Employees by status', [
            'Active' => $activeEmployees,
            'Inactive' => $inactiveEmployees
        ]);
    }

    // Get employees by division
    public function getEmployeesByDivision(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'division_id' => 'required|exists:divisi,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Count employees by division
        $employees = Employee::whereHas('jobs', function ($query) use ($request) {
            $query->where('divisi_id', $request->division_id);
        })->count();

        return new BaseResource(true, 'Employees by division', $employees);
    }
}
