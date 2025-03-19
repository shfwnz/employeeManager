<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::latest()->paginate(5);

        return new BaseResource(true, 'Daftar pekerjaan', $jobs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'required|exists:karyawan,id',
            'divisi_id' => 'required|exists:divisi,id',
            'jabatan_id' => 'required|exists:jabatan,id',
            'tanggal_bergabung' => 'required|date',
            'gaji' => 'required|numric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $job = Job::create([
            'karyawan_id' => $request->karyawan_id,
            'divisi_id' => $request->divisi_id,
            'jabatan_id' => $request->jabatan_id,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'gaji' => $request->gaji,
        ]);

        return new BaseResource(true, 'Data pekerjaan ditambahkan', $job);
    }

    public function show($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Pekerjaan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail pekerjaan', $job);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'karyawan_id' => 'sometimes|required|exists:karyawan,id',
            'divisi_id' => 'sometimes|required|exists:divisi,id',
            'jabatan_id' => 'sometimes|required|exists:jabatan,id',
            'tanggal_bergabung' => 'sometimes|required|date',
            'gaji' => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $job = Job::find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Pekerjaan tidak ditemukan'], 404);
        }

        $job->update($request->all());

        return new BaseResource(true, 'Data Pekerjaan berhasil diupdate', $job);
    }

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
