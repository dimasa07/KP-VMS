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
        $users = Akun::all();
        $rs = new ResultSet();
        $rs->sukses = true;
        $jumlah = count($users);
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data User';
        } else {
            foreach ($users as $user) {
                $user->tamu;
                $user->pegawai;
            }
            $rs->pesan[] = 'Data User ditemukan';
            $rs->hasil->data = $users;
        }

        return $rs;
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
        $users = Akun::where('role', '=', $role)->get();
        $jumlah = count($users);
        $rs = new ResultSet();
        $rs->sukses = true;
        $rs->hasil->jumlah = $jumlah;
        $rs->hasil->tipe = 'Array';
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data User dengan Role ' . $role;
        } else {
            foreach ($users as $akun) {
                if ($role == 'TAMU')
                    $akun->tamu;
                else $akun->pegawai;
            }
            $rs->pesan[] = 'Data User dengan Role ' . $role . ' ditemukan';
            $rs->hasil->data = $users;
        }

        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $akun = $this->getById($id);
        $newUsername = $attributes['username'];
        $cekAkun = $this->getByUsername($newUsername);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($akun)) {
            if (is_null($cekAkun) || $akun->username == $newUsername) {
                $update = $akun->update($attributes);
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses update Akun';
                $rs->hasil->jumlah = 1;
                $rs->hasil->data = $akun;
            } else {
                $rs->pesan[] = 'Gagal update Akun, Username telah tersedia';
            }
        } else {
            $rs->pesan[] = 'Gagal update Akun, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $akun = $this->getById($id);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($akun)) {
            $rs->pesan[] = 'Gagal delete Akun, id tidak ditemukan';
        } else {
            $delete = Akun::where('id', '=', $id)->delete();
            if ($delete) {
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Akun';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan = 'Gagal delete Akun';
            }
        }
        $rs->hasil->data = $akun;
        return $rs;
    }
}
