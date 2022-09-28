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

    public function allTamu()
    {
        $rs = $this->tamuService->getAll();
        return response()->json($rs);
    }

    public function allPegawai()
    {
        $rs = $this->pegawaiService->getAll();
        return response()->json($rs);
    }

    public function allAdmin()
    {
        $rs = $this->pegawaiService->getAllAdmin();
        return response()->json($rs);
    }

    public function allFrontOffice()
    {
        $rs = $this->pegawaiService->getAllFrontOffice();
        return response()->json($rs);
    }

    public function allPermintaanBertamu()
    {
        $rs = $this->permintaanBertamuService->getAll();
        return response()->json($rs);
    }

    public function getTamuByNIK(string $nik)
    {
        $rs = $this->tamuService->getByNIK($nik);
        return response()->json($rs);
    }

    public function setujuiPermintaan(string $idPermintaan)
    {
        $rs = $this->permintaanBertamuService->update($idPermintaan, ['disetujui' => 'YA']);
        return response()->json($rs);
    }

    public function updatePermintaan(Request $request)
    {
        $rs = $this->permintaanBertamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updateBukuTamu(Request $request)
    {
        $rs = $this->bukuTamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }
}
