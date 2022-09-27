<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuTamu extends Model
{
    use HasFactory;

    protected $table = "buku_tamu";
    public $timestamps = false;

    protected $fillable = [
        'id_front_office',
        'id_permintaan',
        'check_in',
        'check_out',
    ];
}
