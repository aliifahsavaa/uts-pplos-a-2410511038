<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyewa::query();

        if ($request->has('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $perPage = $request->get('per_page', 10);
        $penyewa = $query->paginate($perPage);

        return response()->json($penyewa, 200);
    }

    public function show($id)
    {
        $penyewa = Penyewa::find($id);
        if (!$penyewa) {
            return response()->json(['message' => 'Penyewa Tidak Ditemukan.'], 404);
        }
        return response()->json($penyewa, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'nama' => 'required|string',
            'email' => 'required|email',
            'no_telepon' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $penyewa = Penyewa::create($request->all());
        return response()->json($penyewa, 201);
    }

    public function update(Request $request, $id)
    {
        $penyewa = Penyewa::find($id);
        if (!$penyewa) {
            return response()->json(['message' => 'Penyewa Tidak Ditemukan.'], 404);
        }
        $penyewa->update($request->all());
        return response()->json($penyewa, 200);
    }

    public function destroy($id)
    {
        $penyewa = Penyewa::find($id);
        if (!$penyewa) {
            return response()->json(['message' => 'Penyewa Tidak Ditemukan.'], 404);
        }
        $penyewa->delete();
        return response()->json(['message' => 'Penyewa Berhasil Dihapus.'], 200);
    }
}
