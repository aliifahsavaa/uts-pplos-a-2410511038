<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('booking');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('booking_id')) {
            $query->where('booking_id', $request->booking_id);
        }

        $perPage = $request->get('per_page', 10);
        $pembayaran = $query->paginate($perPage);

        return response()->json($pembayaran, 200);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with('booking')->find($id);
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran Tidak Ditemukan.'], 404);
        }
        return response()->json($pembayaran, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer|exists:booking,id',
            'jumlah' => 'required|numeric',
            'tanggal_pembayaran' => 'required|date',
            'status' => 'required|in:lunas,belum_lunas',
            'metode_pembayaran' => 'required|string',
        ]);

        $pembayaran = Pembayaran::create($request->all());
        return response()->json($pembayaran, 201);
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::find($id);
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran Tidak Ditemukan.'], 404);
        }
        $pembayaran->update($request->all());
        return response()->json($pembayaran, 200);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::find($id);
        if (!$pembayaran) {
            return response()->json(['message' => 'Pembayaran Tidak Ditemukan.'], 404);
        }
        $pembayaran->delete();
        return response()->json(['message' => 'Pembayaran Berhasil Dihapus.'], 200);
    }
}