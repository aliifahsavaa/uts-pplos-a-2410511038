<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_telepon',
        'alamat'
    ];
}