<?php

namespace App\Services;

use App\Models\BukuTamu;

class BukuTamuService
{
    public function save(BukuTamu $bukuTamu)
    {
        if(!is_null($this->getByIdPermintaan($bukuTamu->id_permintaan))){
            return null;
        }
        return $bukuTamu->save() ? $bukuTamu : null;
    }

    public function getAll(){
        return BukuTamu::all();
    }

    public function getByIdPermintaan($idPermintaan)
    {
        return BukuTamu::where('id_permintaan', '=', $idPermintaan)->first();
    }
}
