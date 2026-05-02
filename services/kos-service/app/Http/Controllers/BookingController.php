<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['kamar', 'penyewa']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('penyewa_id')) {
            $query->where('penyewa_id', $request->penyewa_id);
        }

        $perPage = $request->get('per_page', 10);
        $booking = $query->paginate($perPage);

        return response()->json($booking, 200);
    }

    public function show($id)
    {
        $booking = Booking::with(['kamar', 'penyewa'])->find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking Tidak Ditemukan.'], 404);
        }
        return response()->json($booking, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|integer|exists:kamar,id',
            'penyewa_id' => 'required|integer|exists:penyewa,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:pending,aktif,selesai,dibatalkan',
        ]);

        $booking = Booking::create($request->all());
        return response()->json($booking, 201);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking Tidak Ditemukan.'], 404);
        }
        $booking->update($request->all());
        return response()->json($booking, 200);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking Tidak Ditemukan.'], 404);
        }
        $booking->delete();
        return response()->json(['message' => 'Booking Berhasil Dihapus.'], 200);
    }
}
