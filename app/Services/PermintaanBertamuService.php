<?php

namespace App\Services;

use App\Models\PermintaanBertamu;

class PermintaanBertamuService
{

    public function save(PermintaanBertamu $permintaanBertamu)
    {
        return $permintaanBertamu->save() ? $permintaanBertamu : null;
    }

    public function getAll()
    {
        return PermintaanBertamu::all();
    }

    public function getById($id): PermintaanBertamu|null
    {
        return PermintaanBertamu::where('id', '=', $id)->first();
    }

    public function update($id, $attributes = [])
    {
        $permintaan = $this->getById($id);

        if (!is_null($permintaan)) {
            $permintaan->update($attributes);
        }

        return $permintaan;
    }

    public function delete($id)
    {
        return PermintaanBertamu::where('id', '=', $id)->delete();
    }
}
