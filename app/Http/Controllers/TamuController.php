<?php

namespace App\Http\Controllers;

use App\Models\PermintaanBertamu;
use App\Services\PermintaanBertamuService;
use Carbon\Carbon;
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
        $waktuPengiriman = Carbon::now()->toDateTimeString();
        $permintaan->waktu_pengiriman = $waktuPengiriman;
        $rs = $this->permintaanBertamuService->save($permintaan);
        return response()->json($rs);
    }

    public function allPermintaanBertamu($idTamu)
    {
        $rs = $this->permintaanBertamuService->getByIdTamu($idTamu);
        return response()->json($rs);
    }

    public function updatePermintaanBertamu(Request $request)
    {
        $rs = $this->permintaanBertamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function deletePermintaanBertamu($id)
    {
        $rs = $this->permintaanBertamuService->delete($id);
        return response()->json($rs);
    }
}
