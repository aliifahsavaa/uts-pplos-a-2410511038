<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $query = Kamar::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('tipe_kamar')) {
            $query->where('tipe_kamar', $request->tipe_kamar);
        }

        $perPage = $request->get('per_page', 10);
        $kamar = $query->paginate($perPage);

        return response()->json($kamar, 200);
    }

    public function show($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Kamar Tidak Ditemukan.'], 404);
        }
        return response()->json($kamar, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string',
            'tipe_kamar' => 'required|string',
            'harga_per_bulan' => 'required|numeric',
            'status' => 'required|in:tersedia,terisi,dalam_perbaikan',
        ]);

        $kamar = Kamar::create($request->all());
        return response()->json($kamar, 201);
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Kamar Tidak Ditemukan.'], 404);
        }
        $kamar->update($request->all());
        return response()->json($kamar, 200);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);
        if (!$kamar) {
            return response()->json(['message' => 'Kamar Tidak Ditemukan.'], 404);
        }
        $kamar->delete();
        return response()->json(['message' => 'Kamar Berhasil Dihapus.'], 200);
    }
}