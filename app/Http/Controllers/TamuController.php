<?php

namespace App\Http\Controllers;

use App\Models\PermintaanBertamu;
use App\Services\PermintaanBertamuService;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function __construct(
        public PermintaanBertamuService $permintaanBertamuService,
    ) {
    }

    public function tambahPermintaan(Request $request)
    {
        $permintaan = new PermintaanBertamu();
        $permintaan->fill($request->input());
        $rs = $this->permintaanBertamuService->save($permintaan);
        return response()->json($rs);
    }
}
