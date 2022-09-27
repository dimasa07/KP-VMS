<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = "akun";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'username',
        'password',
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class, 'id');
    }

    public function tamu()
    {
        return $this->hasMany(Tamu::class, 'id');
    }
}
