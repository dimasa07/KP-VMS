<?php

namespace App\Services;

use App\Models\Akun;
use App\Models\Tamu;

class TamuService
{

    public function save(Tamu $tamu)
    {
        return $tamu->save() ? $tamu : null;
    }

    public function getAll()
    {
        return Tamu::all();
    }

    public function getById($id)
    {
        return Tamu::where('id', '=', $id)->first();
    }

    public function getByNIK($nik)
    {
        return Tamu::where('nik', '=', $nik)->first();
    }

    public function update($id, $attributes = [])
    {
        $tamu = $this->getById($id);
        $newNIK = $attributes['nik'];
        $cekTamu = $this->getByNIK($newNIK);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($tamu)) {
            if (is_null($cekTamu) || $tamu->nik == $newNIK) {
                $update = $tamu->update($attributes);
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses update Tamu';
                $rs->hasil->jumlah= 1;
                $rs->hasil->data = $tamu;
            } else {
                $rs->pesan[] = 'Gagal update Tamu, NIK telah tersedia';
            }
        } else {
            $rs->pesan[] = 'Gagal update Tamu, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $tamu = $this->getById($id);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $akun = null;
        if (is_null($tamu)) {
            $rs->pesan[] = 'Gagal delete Tamu, id tidak ditemukan';
        } else {
            $delete = Tamu::where('id', '=', $id)->delete();
            if ($delete) {
                $akun = Akun::where('id', '=', $tamu->id_akun)->first();
                if (!is_null($akun)) {
                    $akun->delete();
                }
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Tamu';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Tamu';
            }
        }
        $data['tamu'] = $tamu;
        $data['akun'] = $akun;
        $rs->hasil->data = $data;
        return $rs;
    }
}
