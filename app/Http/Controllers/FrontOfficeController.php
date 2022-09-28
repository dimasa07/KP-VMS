<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Services\BukuTamuService;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    public function __construct(
        public BukuTamuService $bukuTamuService
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
        $bukuTamu = new BukuTamu();
        $bukuTamu->fill($request->input());
        $rs = $this->bukuTamuService->save($bukuTamu);
        return response()->json($rs);
    }

    public function allBukuTamu()
    {
        $rs = $this->bukuTamuService->getAll();
        return response()->json($rs);
    }
}
