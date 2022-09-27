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
        $idPermintaan = $request->input('id_permintaan');
        $bukuTamu = new BukuTamu();
        $bukuTamu->fill($request->input());
        $bukuTamu = $this->bukuTamuService->save($bukuTamu);

        if (is_null($bukuTamu)) {
            $resp['message'][] = 'Gagal check-in';
        } else {
            $resp = [
                'message' => 'Sukses check-in',
                'buku_tamu' => $bukuTamu
            ];
        }

        return response()->json($resp);
    }

    public function checkOut()
    {
    }

    public function allBukuTamu()
    {
        $semuaBukuTamu = $this->bukuTamuService->getAll();
        $jumlah = count($semuaBukuTamu); 
        if ($jumlah == 0) {
            $resp['message'][] = 'Tidak ada data Buku Tamu';
        } else {
            $resp = [
                'message' => 'Data Buku Tamu ditemukan, jumlah ' . $jumlah . ' data',
                'buku_tamu' => $semuaBukuTamu
            ];
        }

        return response()->json($resp);
    }
}
