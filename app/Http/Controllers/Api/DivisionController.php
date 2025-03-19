<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::latest()->paginate(5);

        return new BaseResource(true, 'Daftar divisi', $divisions);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $division = Division::create([
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi
        ]);

        return new BaseResource(true, 'Data divisi ditambahkan', $division);
    }

    public function show($id)
    {
        $division = Division::find($id);
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail divisi', $division);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'sometimes|required|string|max:100',
            'deskripsi' => 'sometimes|required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $division = Division::find($id);
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        $division->update($request->all());

        return new BaseResource(true, 'Data divisi berhasil diupdate', $division);
    }

    public function destroy($id)
    {
        $division = Division::find($id);
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }
        $division->delete();

        return new BaseResource(true, 'Data divisi berhasil dihapus', $division);
    }
}
