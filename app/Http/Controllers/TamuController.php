<?php

namespace App\Http\Controllers;

use App\Models\PermintaanBertamu;
use App\Services\AkunService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\TamuService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function __construct(
        public TamuService $tamuService,
        public AkunService $akunService,
        public PermintaanBertamuService $permintaanBertamuService,
        public PegawaiService $pegawaiService
    ) {
    }

    public function index()
    {
        return view('tamu.index');
    }

    public function viewBuatPermintaan()
    {
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        return view('tamu.tambah_permintaan', compact('pegawai'));
    }

    public function riwayatPermintaan()
    {
        return view('tamu.riwayat_permintaan');
    }

    public function riwayatBertamu()
    {
        return view('tamu.riwayat_bertamu');
    }

    public function tambahPermintaan(Request $request)
    {
        // $waktuPengiriman = Carbon::now()->toDateTimeString();
        // $permintaan->waktu_pengiriman = $waktuPengiriman;
        // $rs = $this->permintaanBertamuService->save($permintaan);
        $id_tamu = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data->tamu->id;
        $waktu_bertamu = $request->input('tanggal') . ' ' . $request->input('waktu') . ':00';
        $id_pegawai = $request->input('id_pegawai');
        $keperluan = $request->input('keperluan');
        $waktu_pengiriman = Carbon::now()->toDateTimeString();
        $data = [
            'id_tamu' => $id_tamu,
            'id_pegawai' => $id_pegawai,
            'keperluan' => $keperluan,
            'waktu_bertamu' => $waktu_bertamu,
            'waktu_pengiriman' => $waktu_pengiriman
        ];
        $permintaan = new PermintaanBertamu();
        $permintaan->fill($data);
        $rs = $this->permintaanBertamuService->save($permintaan);
        return back();
        // return response()->json($data);
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
