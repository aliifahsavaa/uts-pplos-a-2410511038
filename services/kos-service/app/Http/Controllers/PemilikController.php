<?php

namespace App\Http\Controllers;

use App\Models\Pemilik;
use Illuminate\Http\Request;

class PemilikController extends Controller
{
    public function index(Request $request)
    {
        $query = Pemilik::query();

        if ($request->has('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage), 200);
    }

    public function show($id)
    {
        $pemilik = Pemilik::find($id);
        if (!$pemilik) {
            return response()->json(['message' => 'Pemilik Tidak Ditemukan.'], 404);
        }
        return response()->json($pemilik, 200);
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

        $pemilik = Pemilik::create($request->all());
        return response()->json($pemilik, 201);
    }

    public function update(Request $request, $id)
    {
        $pemilik = Pemilik::find($id);
        if (!$pemilik) {
            return response()->json(['message' => 'Pemilik Tidak Ditemukan.'], 404);
        }
        $pemilik->update($request->all());
        return response()->json($pemilik, 200);
    }

    public function destroy($id)
    {
        $pemilik = Pemilik::find($id);
        if (!$pemilik) {
            return response()->json(['message' => 'Pemilik Tidak Ditemukan.'], 404);
        }
        $pemilik->delete();
        return response()->json(['message' => 'Pemilik Berhasil Dihapus.'], 200);
    }
}