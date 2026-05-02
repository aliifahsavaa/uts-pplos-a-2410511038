<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewa extends Model
{
    protected $table = 'penyewa';

    protected $fillable = [
        'user_id', 
        'nama',
        'email',
        'no_telepon',
        'alamat'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'penyewa_id');
    }
}