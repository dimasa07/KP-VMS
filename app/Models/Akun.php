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
        'id_user',
        'role',
        'status',
        'username',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    
}
