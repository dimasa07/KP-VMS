<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\PermintaanBertamu;
use App\Models\Tamu;
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

    public function index()
    {
        return view('front_office.index');
    }

    public function viewCheckIn()
    {
        $rs = $this->permintaanBertamuService->getByStatus('DISETUJUI');
        $permintaan = $rs->hasil->data;
        return view('front_office.check_in', compact('permintaan'));
    }

    public function viewCheckOut()
    {
        $rs = $this->permintaanBertamuService->getByStatus('KADALUARSA');
        $permintaan = [];
        foreach ($rs->hasil->data as $data) {
            if ($data->buku_tamu->check_out == null) {
                $permintaan[] = $data;
            }
        }
        return view('front_office.check_out', compact('permintaan'));
        // return response()->json($rs);
    }

    public function viewBuatPermintaan()
    {
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        return view('front_office.tambah_permintaan',compact('pegawai'));
    }

    public function checkIn(Request $request, int $id_permintaan)
    {
        $datetime = Carbon::now()->toDateTimeString();
        $id_front_office = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data->pegawai->id;
        $attributes = [
            'id_front_office' => $id_front_office,
            'id_permintaan' => $id_permintaan,
            'check_in' => $datetime
        ];
        $bukuTamu = new BukuTamu();
        $bukuTamu->fill($attributes);
        $rs = $this->bukuTamuService->save($bukuTamu);
        if ($rs->sukses) {
            $this->permintaanBertamuService->update($id_permintaan, ['status' => 'KADALUARSA']);
        }
        return back();
        // return response()->json($id_front_office);
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

        return back();
        // return response()->json($rs);
    }

    public function tambahPermintaan(Request $request)
    {
        $rsTamu = $this->tamuService->getByNIK($request->input('nik'));
        if(!$rsTamu->sukses){
            $tamu = new Tamu();
            $tamu->fill($request->input());
            $rsTamu = $this->tamuService->save($tamu);
        }
        $id_tamu = $rsTamu->hasil->data->id;
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
        // return response()->json($rs);
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

    public function profil(Request $request)
    {
        $rs = $this->pegawaiService->getByNIP($request->session()->get('nip'));
        $frontOffice = $rs->hasil->data;
        return view('front_office.profil', compact('frontOffice'));
        // return response()->json($admin);
    }

    public function akun(Request $request)
    {
        $rs = $this->akunService->getByUsername($request->session()->get('username'));
        $akun = $rs->hasil->data;
        return view('front_office.akun', compact('akun'));
        // return response()->json($admin);
    }

    public function updateProfil(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        if($rs->sukses){
            $request->session()->put('username',$request->input('username'));
        }
        return response()->json($rs);
    }

    public function deleteBukuTamu(int $id)
    {
        $rs = $this->bukuTamuService->delete($id);
        return response()->json($rs);
    }
}
