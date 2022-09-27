<?php

namespace App\Services;

use App\Models\Akun;

class AkunService
{
    public function save(Akun $akun)
    {
        if (!is_null($this->getByUsername($akun->username))) {
            return null;
        }
        $akun->save();
        return $akun;
    }

    public function getAll()
    {
        return Akun::all();
    }

    public function getById($id)
    {
        return Akun::where('id', '=', $id)->first();
    }

    public function getByUsername($username)
    {
        return Akun::where('username', '=', $username)->first();
    }

    public function getByUsernameAndPassword($username, $password)
    {
        return Akun::where([
            ['username', '=', $username],
            ['password', '=', $password]
        ])->first();
    }

    public function getByRole($role)
    {
        return Akun::where('role', '=', $role)->get();
    }

    public function getByStatus($status)
    {
        return Akun::where('status', '=', $status)->get();
    }

    public function update($id, $attributes = [])
    {
        $akun = $this->getById($id);

        if (!is_null($akun)) {
            $akun->update($attributes);
        }

        return $akun;
    }

    public function delete($id)
    {
        return Akun::where('id', '=', $id)->delete();
    }
}
