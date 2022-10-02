<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\ResultSet;
use App\Services\TamuService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    public function __construct(
        public PegawaiService $pegawaiService,
        public AkunService $akunService,
        public BukuTamuService $bukuTamuService,
        public TamuService $tamuService,
        public PermintaanBertamuService $permintaanBertamuService
    ) {
    }

    public function checkIn(int $idPermintaan)
    {
        $datetime = Carbon::now()->toDateTimeString();
        $attributes = [
            'id_front_office' => 2,
            'id_permintaan' => $idPermintaan,
            'check_in' => $datetime
        ];
        $bukuTamu = new BukuTamu();
        $bukuTamu->fill($attributes);
        $rs = $this->bukuTamuService->save($bukuTamu);
        return response()->json($rs);
    }

    public function checkOut(int $idBukuTamu)
    {
        $cekBukuTamu = $this->bukuTamuService->getById($idBukuTamu)->hasil->data;
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';

        if (is_null($cekBukuTamu)) {
            $rs->pesan[] = 'Gagal check-out, id Buku Tamu tidak ditemukan';
        } else {
            $isCheckedOut = $cekBukuTamu->check_out;
            if (is_null($isCheckedOut)) {
                $datetime = Carbon::now()->toDateTimeString();
                $rsUpdate = $this->bukuTamuService->update($idBukuTamu, ['check_out' => $datetime]);
                if ($rsUpdate->sukses) {
                    $rs->hasil->jumlah = 1;
                    $rs->pesan[] = 'Sukses check-out';
                    $rs->hasil->data = $rsUpdate->hasil->data;
                } else {
                    $rs->pesan[] = 'Gagal check-out, ' . $rsUpdate->pesan[0];
                }
            } else {
                $rs->pesan[] = 'Gagal check-out, Tamu tersebut telah melakukan check-out';
            }
        }

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

    public function updateProfil(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function deleteBukuTamu(int $id)
    {
        $rs = $this->bukuTamuService->delete($id);
        return response()->json($rs);
    }

    
}
