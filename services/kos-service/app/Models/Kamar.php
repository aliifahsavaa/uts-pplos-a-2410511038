<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';

    protected $fillable = [
        'nomor_kamar',
        'tipe_kamar',
        'harga_per_bulan',
        'status',
        'deskripsi'
    ];
    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kamar_id');
    }
}