<?php

namespace App\Http\Controllers;

use App\Models\PermintaanBertamu;
use App\Services\PermintaanBertamuService;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function __construct(
        public PermintaanBertamuService $permintaanBertamuService
    ) {
    }

    public function tambahPermintaan(Request $request)
    {
        $permintaan = new PermintaanBertamu();
        $permintaan->fill($request->input());
        $permintaan = $this->permintaanBertamuService->save($permintaan);
        if (is_null($permintaan)) {
            $resp['message'][] = 'Gagal menambah permintaan';
        } else {
            $resp = [
                'message' => 'Sukses menambah permintaan',
                'permintaan' => $permintaan
            ];
        }

        return response()->json($resp);
    }
}
