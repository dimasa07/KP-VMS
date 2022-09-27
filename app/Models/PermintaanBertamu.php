<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanBertamu extends Model
{
    use HasFactory;

    protected $table = "permintaan_bertamu";
    public $timestamps = false;

    protected $fillable = [
        'id_tamu',
        'id_admin',
        'id_pegawai',
        'keperluan',
        'waktu_bertamu',
        'disetujui',
        'pesan_ditolak'
    ];

    public function frontOffice()
    {
        return $this->belongsToMany(
            User::class,
            'buku_tamu',
            'id',
            'id_front_office'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            User::class,
            'id_admin'
        );
    }

    public function tamu()
    {
        return $this->belongsToMany(
            User::class,
            'permintaan_bertamu',
            'id',
            'id_tamu'
        );
    }

    public function pegawai()
    {
        return $this->belongsToMany(
            Pegawai::class,
            'permintaan_bertamu',
            'id',
            'id_pegawai'
        );
    }
}
