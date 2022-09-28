<?php

namespace App\Services;

use App\Models\Akun;
use App\Models\Pegawai;

class PegawaiService
{
    public function __construct(
        public AkunService $akunService
    ) {
    }

    public function save(Pegawai $pegawai)
    {
        return $pegawai->save() ? $pegawai : null;
    }

    public function getAll()
    {
        return Pegawai::all();
    }

    public function getAllAdmin()
    {
        $admins = [];
        $akuns = $this->akunService->getByRole('ADMIN');
        foreach ($akuns as $akun) {
            $admins[] = $akun->pegawai;
        }

        return $admins;
    }

    public function getAllFrontOffice()
    {
        $frontOffices = [];
        $akuns = $this->akunService->getByRole('FRONT OFFICE');
        foreach ($akuns as $akun) {
            $frontOffices[] = $akun->pegawai;
        }

        return $frontOffices;
    }

    public function getById($id)
    {
        return Pegawai::where('id', '=', $id)->first();
    }

    public function getByNIP($nip)
    {
        return Pegawai::where('nip', '=', $nip)->first();
    }

    public function update($id, $attributes = [])
    {
        $pegawai = $this->getById($id);

        if (!is_null($pegawai)) {
            $pegawai->update($attributes);
        }

        return $pegawai;
    }

    public function delete($id)
    {
        $pegawai = $this->getById($id);
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $akun = null;
        if (is_null($pegawai)) {
            $rs->pesan[] = 'Gagal delete Pegawai, id tidak ditemukan';
        } else {
            $delete = Pegawai::where('id', '=', $id)->delete();
            if ($delete) {
                $akun = Akun::where('id', '=', $pegawai->id_akun)->first();
                if (!is_null($akun)) {
                    $akun->delete();
                }
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Pegawai';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Pegawai';
            }
        }
        $data['pegawai'] = $pegawai;
        $data['akun'] = $akun;
        $rs->hasil->data = $data;
        return $rs;
    }
}
