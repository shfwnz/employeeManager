<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    // get all divisions
    public function index()
    {
        // get latest divisions
        $divisions = Division::latest()->paginate(5);

        // return response
        return new BaseResource(true, 'Daftar divisi', $divisions);
    }

    // create division
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create division
        $division = Division::create([
            'nama_divisi' => $request->nama_divisi,
            'deskripsi' => $request->deskripsi
        ]);

        // return response
        return new BaseResource(true, 'Data divisi ditambahkan', $division);
    }

    // get division by id
    public function show($id)
    {
        // find division
        $division = Division::find($id);

        // not found?
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // return response
        return new BaseResource(true, 'Detail divisi', $division);
    }

    // update division
    public function update(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'nama_divisi' => 'sometimes|required|string|max:100',
            'deskripsi' => 'sometimes|required|string|max:255'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // find division
        $division = Division::find($id);

        // not found?
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // update division
        $division->update($request->all());

        // return response
        return new BaseResource(true, 'Data divisi berhasil diupdate', $division);
    }

    // delete division
    public function destroy($id)
    {
        // find division
        $division = Division::find($id);

        // not found?
        if (!$division) {
            return response()->json(['success' => false, 'message' => 'divisi tidak ditemukan'], 404);
        }

        // delete division
        $division->delete();

        // return response
        return new BaseResource(true, 'Data divisi berhasil dihapus', $division);
    }
}
