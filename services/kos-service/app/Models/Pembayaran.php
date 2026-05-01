<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'booking_id',
        'jumlah',
        'tanggal_pembayaran',
        'status',
        'metode_pembayaran'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}