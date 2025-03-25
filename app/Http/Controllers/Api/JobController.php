<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    // job list
    public function index()
    {
        $jobs = Job::with([
            'employee',
            'division',
            'position'
        ])->latest()->paginate(5);

        return new BaseResource(true, 'Daftar pekerjaan', $jobs);
    }

    // Create a new job
    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'required|exists:karyawan,id',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'tanggal_bergabung' => 'required|date',
            'gaji' => 'required|numeric|min:0',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create job record
        $job = Job::create([
            'karyawan_id' => $request->karyawan_id,
            'divisi_id' => $request->divisi_id,
            'jabatan_id' => $request->jabatan_id,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'gaji' => $request->gaji,
        ]);

        return new BaseResource(true, 'Data pekerjaan ditambahkan', $job);
    }

    // Show job details
    public function show($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Pekerjaan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail pekerjaan', $job);
    }

    // Update job record
    public function update(Request $request, $id)
    {
        // Validate request data (optional fields)
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'sometimes|required|exists:karyawan,id',
            'divisi_id' => 'sometimes|required|exists:divisi,id',
            'jabatan_id' => 'sometimes|required|exists:jabatan,id',
            'tanggal_bergabung' => 'sometimes|required|date',
            'gaji' => 'sometimes|required|numeric|min:0',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find by ID
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Pekerjaan tidak ditemukan'], 404);
        }

        // Update job data
        $job->update($request->all());

        return new BaseResource(true, 'Data Pekerjaan berhasil diupdate', $job);
    }

    // Delete a job
    public function destroy($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Pekerjaan tidak ditemukan'], 404);
        }
        $job->delete();

        return new BaseResource(true, 'Data pekerjaan berhasil dihapus', $job);
    }
}
