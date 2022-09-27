<?php

namespace App\Http\Controllers;

use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(
        public PegawaiService $pegawaiService,
        public BukuTamuService $bukuTamuService,
        public PermintaanBertamuService $permintaanBertamuService
    ) {
    }

    public function allPegawai()
    {
        $semuaPegawai = $this->pegawaiService->getAll();
        $jumlah = count($semuaPegawai);
        if ($jumlah == 0) {
            $resp['message'][] = 'Tidak ada data Pegawai';
        } else {
            $resp = [
                'message' => 'Data Pegawai ditemukan, jumlah ' . $jumlah . ' data',
                'pegawai' => $semuaPegawai
            ];
        }
        return response()->json($resp);
    }

    public function allPermintaanBertamu()
    {
        $semuaPermintaan = $this->permintaanBertamuService->getAll();
        foreach ($semuaPermintaan as $permintaan) {
            $permintaan->admin;
            $permintaan->pegawai;
            $permintaan->tamu;
        }

        $jumlah = count($semuaPermintaan);

        if ($jumlah == 0) {
            $resp['message'][] = 'Tidak ada data Permintaan Bertamu';
        } else {
            $resp = [
                'message' => 'Data Permintaan Bertamu ditemukan, jumlah ' . $jumlah . ' data',
                'permintaan' => $semuaPermintaan
            ];
        }

        return response()->json($resp);
    }

    public function setujuiPermintaan(string $idPermintaan)
    {
        $permintaan = $this->permintaanBertamuService->update($idPermintaan, ['disetujui' => 'YA']);

        if (is_null($permintaan)) {
            $resp['message'][] = 'Gagal menyetujui, id tidak ditemukan';
        } else {
            $permintaan->update([
                'id_admin' => 1
            ]);
            $resp = [
                'message' => 'Sukses menyetujui permintaan',
                'permintaan' => $permintaan
            ];
        }

        return response()->json($resp);
    }

    public function updatePermintaan(Request $request)
    {
        $idPermintaan = $request->input('id');
        $update = $this->permintaanBertamuService->update($idPermintaan, $request->input());

        if (is_null($update)) {
            $resp['message'][] = 'Gagal update Permintaan Bertamu';
            $resp['attributes'] = $request->input();
        } else {
            $resp = [
                'message' => 'Sukses update Permintaan Bertamu',
                'permintaan' => $update
            ];
        }
        return response()->json($resp);
    }

    public function updateBukuTamu(Request $request)
    {
        $idBukuTamu = $request->input('id');
        $update = $this->bukuTamuService->update($idBukuTamu, $request->input());

        if (is_null($update)) {
            $resp['message'][] = 'Gagal update Buku Tamu';
            $resp['attributes'] = $request->input();
        } else {
            $resp = [
                'message' => 'Sukses update Buku Tamu',
                'permintaan' => $update
            ];
        }
        return response()->json($resp);
    }
}
