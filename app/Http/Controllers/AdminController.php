<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Pegawai;
use App\Services\AkunService;
use App\Services\BukuTamuService;
use App\Services\PegawaiService;
use App\Services\PermintaanBertamuService;
use App\Services\ResultSet;
use App\Services\TamuService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct(
        public AkunService $akunService,
        public PegawaiService $pegawaiService,
        public BukuTamuService $bukuTamuService,
        public PermintaanBertamuService $permintaanBertamuService,
        public TamuService $tamuService
    ) {
    }

    public function index()
    {
        return view('admin.index');
    }

    public function tambahPegawai(Request $request)
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $pegawai = new Pegawai();
        $pegawai->fill($request->input());
        $cekPegawai = $this->pegawaiService->getByNIP($pegawai->nip);
        if ($cekPegawai->sukses) {
            $rs->pesan[] = 'Gagal daftar, NIP sudah terdaftar';
        } else {
            $akun = null;
            if ($request->input('username') != '') {
                $akun = new Akun();
                $akun->fill($request->input());
                $saveAkun = $this->akunService->save($akun);
                if (!$saveAkun->sukses) {
                    $rs->pesan = $saveAkun->pesan;
                    return response()->json($rs);
                } else {
                    $pegawai->id_akun = $akun->id;
                }
            }
            $savePegawai = $this->pegawaiService->save($pegawai);
            $rs->sukses = $savePegawai->sukses;
            $rs->pesan[] = 'Sukses tambah Pegawai';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data['pegawai'] = $pegawai;
            $rs->hasil->data['akun'] = $akun;
        }

        return response()->json($rs);
    }

    public function profil(Request $request)
    {
        $rs = $this->pegawaiService->getByNIP($request->session()->get('nip'));
        $admin = $rs->hasil->data;
        return view('admin.profil', compact('admin'));
        // return response()->json($admin);
    }

    public function akun(Request $request)
    {
        $rs = $this->akunService->getByUsername($request->session()->get('username'));
        $akun = $rs->hasil->data;
        return view('admin.akun', compact('akun'));
        // return response()->json($admin);
    }

    public function allPegawai()
    {
        $rs = $this->pegawaiService->getAll();
        $pegawai = $rs->hasil->data;
        return view('admin.data_pegawai', compact('pegawai'));
        // return response()->json($admin);
    }

    public function allAdmin()
    {
        $rs = $this->pegawaiService->getAllAdmin();
        $admin = $rs->hasil->data;
        return view('admin.data_admin', compact('admin'));
        // return response()->json($rs);
    }

    public function allFrontOffice()
    {
        $rs = $this->pegawaiService->getAllFrontOffice();
        $frontOffice = $rs->hasil->data;
        return view('admin.data_front_office', compact('frontOffice'));
        // return response()->json($rs);
    }

    public function allTamu()
    {
        $rs = $this->tamuService->getAll();
        $tamu = $rs->hasil->data;
        return view('admin.data_tamu', compact('tamu'));
        //return response()->json($rs);
    }

    public function allPermintaanBertamu(Request $request)
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
        return view('admin.data_permintaan', [], [
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
        return view('admin.data_buku_tamu', compact('bukuTamu'));
        // return response()->json($rs);
    }

    public function getTamuByNIK(string $nik)
    {
        $rs = $this->tamuService->getByNIK($nik);
        return response()->json($rs);
    }

    public function setujuiPermintaan(Request $request, string $idPermintaan)
    {
        $admin = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data;
        $waktuPemeriksaan = Carbon::now()->toDateTimeString();
        $rs = $this->permintaanBertamuService->update($idPermintaan, [
            'status' => 'DISETUJUI',
            'waktu_pemeriksaan' => $waktuPemeriksaan,
            'id_admin' => $admin->id
        ]);
        return back();
    }

    public function tolakPermintaan(Request $request)
    {
        $admin = $this->akunService->getByUsername($request->session()->get('username'))->hasil->data;
        $waktuPemeriksaan = Carbon::now()->toDateTimeString();
        $rs = $this->permintaanBertamuService->update($request->input('id'), [
            'status' => 'DITOLAK',
            'waktu_pemeriksaan' => $waktuPemeriksaan,
            'id_admin' => $admin->id,
            'pesan_ditolak' => $request->input('pesan_ditolak')
        ]);
        // var_dump($request->input());
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
        if($rs->sukses){
            $request->session()->put('username',$request->input('username'));
        }
        return response()->json($rs);
    }

    public function updatePegawai(Request $request)
    {
        $rs = $this->pegawaiService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    

    public function updateBukuTamu(Request $request)
    {
        $rs = $this->bukuTamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function deleteTamu($id)
    {
        $rs = $this->tamuService->delete($id);
        return back();
        // return response()->json($rs);
    }
}
