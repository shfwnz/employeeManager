<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    // get all positions
    public function index()
    {
        $positions = Position::latest()->paginate(5);

        return new BaseResource(true, 'Daftar jabatan', $positions);
    }

    // create position
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // create new position
        $position = Position::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi
        ]);

        return new BaseResource(true, 'Data jabatan ditambahkan', $position);
    }

    // get position by id
    public function show($id)
    {
        $position = Position::find($id);

        // not found?
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail jabatan', $position);
    }

    // update position by id
    public function update(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'sometimes|required|string|max:100',
            'deskripsi' => 'sometimes|required|string|max:255'
        ]);

        // validation failed?
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = Position::find($id);

        // not found?
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }

        // update position
        $position->update($request->all());

        return new BaseResource(true, 'Data jabatan berhasil diupdate', $position);
    }

    // delete position by id
    public function destroy($id)
    {
        $position = Position::find($id);

        // not found?
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }

        // delete position
        $position->delete();

        return new BaseResource(true, 'Data jabatan berhasil dihapus', $position);
    }
}
