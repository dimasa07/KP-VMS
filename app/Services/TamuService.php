<?php

namespace App\Services;

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

        if (!is_null($tamu)) {
            $tamu->update($attributes);
        }

        return $tamu;
    }

    public function delete($id)
    {
        return Tamu::where('id', '=', $id)->delete();
    }
}
