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

    public function getById($id)
    {
        return BukuTamu::where('id', '=', $id)->first();
    }

    public function getByIdPermintaan($idPermintaan)
    {
        return BukuTamu::where('id_permintaan', '=', $idPermintaan)->first();
    }

    public function update($id, $attributes = [])
    {
        $bukuTamu = $this->getById($id);

        if (!is_null($bukuTamu)) {
            $bukuTamu->update($attributes);
        }

        return $bukuTamu;
    }

    public function delete($id)
    {
        return BukuTamu::where('id', '=', $id)->delete();
    }
}
