<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function save(User $user)
    {
        if (!is_null($this->getByNIK($user->nik))) {
            return null;
        }
        $user->save();
        return $user;
    }

    public function getAll()
    {
        return User::all();
    }

    public function getByUsername($username)
    {
        return User::where('username', '=', $username)->first();
    }

    public function getByUsernameAndPassword($username, $password)
    {
        return User::where([
            ['username', '=', $username],
            ['password', '=', $password]
        ])->first();
    }

    public function getByNIK($nik)
    {
        return User::where('nik', '=', $nik)->first();
    }

    public function getByNIP($nip)
    {
        return User::where('nip', '=', $nip)->first();
    }

}
