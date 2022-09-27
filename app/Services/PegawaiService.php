<?php

namespace App\Services;

use App\Models\Pegawai;

class PegawaiService{

    public function getAll(){
        return Pegawai::all();
    }

    public function getById($id)
    {
        return Pegawai::where('id', '=', $id)->first();
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
        return Pegawai::where('id', '=', $id)->delete();
    }
}