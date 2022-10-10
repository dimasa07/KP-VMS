<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\ResultSet;
use App\Services\TamuService;
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

    public function index()
    {
        return view('front_office.index');
    }

    public function viewCheckIn(){
        return view('front_office.check_in');
    }

    public function viewCheckOut(){
        return view('front_office.check_out');
    }

    public function viewBuatPermintaan(){
        return view('front_office.tambah_permintaan');
    }

    public function checkIn(int $idPermintaan)
    {
        $datetime = '';  //Carbon::now()->toDateTimeString();
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
                $datetime = ''; //Carbon::now()->toDateTimeString();
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
        $tamu = $rs->hasil->data;
        return view('front_office.data_tamu', compact('tamu'));
    }

    public function allPermintaanBertamu()
    {
        $rs1 = $this->permintaanBertamuService->getByStatus('BELUM DIPERIKSA');
        $rs2 = $this->permintaanBertamuService->getByStatus('DISETUJUI');
        $rs3 = $this->permintaanBertamuService->getByStatus('DITOLAK');
        $permintaanBelumDiperiksa = $rs1->hasil->data;
        $permintaanDisetujui = $rs2->hasil->data;
        $permintaanDitolak = $rs3->hasil->data;
        // if ($request->ajax()) {
        //     return response()->json(array('permintaan' => $permintaan));
        // }
        return view('front_office.data_permintaan', [], [
            'permintaanBelumDiperiksa' => $permintaanBelumDiperiksa,
            'permintaanDisetujui' => $permintaanDisetujui,
            'permintaanDitolak' => $permintaanDitolak
        ]);

        // return response()->json($rs);
    }

    public function allBukuTamu()
    {
        $rs = $this->bukuTamuService->getAll();
        $bukuTamu = $rs->hasil->data;
        return view('front_office.data_buku_tamu', compact('bukuTamu'));
        // return response()->json($rs);
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
