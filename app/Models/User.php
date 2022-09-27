<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = "user";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'nik',
        'nama',
        'no_telepon',
        'email',
    ];

    public function akun()
    {
        return $this->hasOne(Akun::class, 'id_user');
    }


}
