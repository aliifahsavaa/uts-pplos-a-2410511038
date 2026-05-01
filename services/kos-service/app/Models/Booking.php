<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'kamar_id',
        'penyewa_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'status'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }

    public function penyewa()
    {
        return $this->belongsTo(Penyewa::class, 'penyewa_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'booking_id');
    }
}