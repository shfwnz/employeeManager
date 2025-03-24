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

        // is fail?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // find id
        $division = Division::find($id);

        // is exist
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // update all data
        $division->update($request->all());

        return new BaseResource(true, 'Data divisi berhasil diupdate', $division);
    }

    // delete by id
    public function destroy($id)
    {
        // find id
        $division = Division::find($id);

        // is exist
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // delete 
        $division->delete();

        return new BaseResource(true, 'Data divisi berhasil dihapus', $division);
    }
}
