<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Services\BukuTamuService;
use App\Services\PermintaanBertamuService;
use App\Services\TamuService;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    public function __construct(
        public BukuTamuService $bukuTamuService,
        public TamuService $tamuService,
        public PermintaanBertamuService $permintaanBertamuService
    ) {
    }

    public function checkIn(Request $request)
    {
        $bukuTamu = new BukuTamu();
        $bukuTamu->fill($request->input());
        $rs = $this->bukuTamuService->save($bukuTamu);
        return response()->json($rs);
    }

    public function checkOut(Request $request)
    {
        $rs = $this->bukuTamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function allTamu()
    {
        $rs = $this->tamuService->getAll();
        return response()->json($rs);
    }

    public function allPermintaanBertamu()
    {
        $rs = $this->permintaanBertamuService->getAll();
        return response()->json($rs);
    }

    public function allBukuTamu()
    {
        $rs = $this->bukuTamuService->getAll();
        return response()->json($rs);
    }
}
