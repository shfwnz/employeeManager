<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->paginate(5);

        return new BaseResource(true, 'Daftar jabatan', $positions);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = Position::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi
        ]);

        return new BaseResource(true, 'Data jabatan ditambahkan', $position);
    }

    public function show($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }

        return new BaseResource(true, 'Detail jabatan', $position);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'sometimes|required|string|max:100',
            'deskripsi' => 'sometimes|required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $position = Position::find($id);
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }

        $position->update($request->all());

        return new BaseResource(true, 'Data jabatan berhasil diupdate', $position);
    }

    public function destroy($id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json(['success' => false, 'message' => 'jabatan tidak ditemukan'], 404);
        }
        $position->delete();

        return new BaseResource(true, 'Data jabatan berhasil dihapus', $position);
    }
}
