<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index(Request $request)
    {
        $query = Fasilitas::with('kamar');

        if ($request->has('kamar_id')) {
            $query->where('kamar_id', $request->kamar_id);
        }

        $perPage = $request->get('per-page', 10);
        return response()->json($query->paginate($perPage), 200);
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::with('kamar')->find($id);
        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas Tidak Ditemukan.'], 404);
        }
        return response()->json($fasilitas, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|integer|exists:kamar.id',
            'nama_fasilitas' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $fasilitas = Fasilitas::create($request->all());
        return response()->json($fasilitas, 201);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::find($id);
        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas Tidak Ditemukan.'], 404);
        }
        $fasilitas->update($request->all());
        return response()->json($fasilitas, 200);
        }

        public function destroy($id)
        {
            $fasilitas = Fasilitas::find($id);
            if (!$fasilitas) {
                return response()->json(['message' => 'Fasilitas Tidak Ditemukan.'], 404);
            }
            $fasilitas->delete();
            return response()->json(['message' => 'Fasilitas Berhasil Dihapus.'], 200);
    }
}
