<?php

namespace App\Services;

use App\Models\Pegawai;

class PegawaiService{

    public function getAll(){
        return Pegawai::all();
    }
}