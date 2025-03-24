<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    // display division
    public function index()
    {
        $divisions = Division::latest()->paginate(5);

        return new BaseResource(true, 'Daftar divisi', $divisions);
    }

    // save division
    public function store(Request $request)
    {
        // check validation
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255'
        ]);

        // is fail?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create division if not fail
        $division = Division::create([
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi
        ]);

        return new BaseResource(true, 'Data divisi ditambahkan', $division);
    }

    // display by id
    public function show($id)
    {
        // find id
        $division = Division::find($id);

        // is exist
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail divisi', $division);
    }

    // update by id
    public function update(Request $request, $id)
    {
        // check validation
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'sometimes|required|string|max:100',
            'deskripsi' => 'sometimes|required|string|max:255'
        ]);

        // Jika validasi gagal, kembalikan response dengan status 422 (Unprocessable Entity)
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mencari divisi berdasarkan ID
        $division = Division::find($id);

        // Jika divisi tidak ditemukan, kembalikan response dengan status 404
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // Mengupdate data divisi dengan data dari request
        $division->update($request->all());

        // Mengembalikan response sukses setelah update
        return new BaseResource(true, 'Data divisi berhasil diupdate', $division);
    }

    // Method untuk menghapus divisi berdasarkan ID
    public function destroy($id)
    {
        // Mencari divisi berdasarkan ID
        $division = Division::find($id);

        // Jika divisi tidak ditemukan, kembalikan response dengan status 404
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // Menghapus data divisi dari database
        $division->delete();

        // Mengembalikan response sukses setelah divisi dihapus
        return new BaseResource(true, 'Data divisi berhasil dihapus', $division);
    }
}
