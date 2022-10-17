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
use App\Utilities\WaktuConverter;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        return view('front_office.tambah_permintaan', compact('pegawai'));
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
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
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
                    $rs->sukses = true;
                    $rs->pesan[] = 'Sukses Check-out';
                    $rs->hasil->data = $rsUpdate->hasil->data;
                } else {
                    $rs->pesan[] = 'Gagal Check-out, ' . $rsUpdate->pesan[0];
                }
            } else {
                $rs->pesan[] = 'Gagal Check-out, Tamu tersebut telah melakukan Check-out';
            }
        }

        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
        // return response()->json($rs);
    }

    public function tambahPermintaan(Request $request)
    {
        $rsTamu = $this->tamuService->getByNIK($request->input('nik'));
        if (!$rsTamu->sukses) {
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
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        return back()->with($tipe, $rs->pesan[0]);
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
        $rs = $this->permintaanBertamuService->getAll();
        $rs1 = $this->permintaanBertamuService->getByStatus('BELUM DIPERIKSA');
        $rs2 = $this->permintaanBertamuService->getByStatus('DISETUJUI');
        $rs3 = $this->permintaanBertamuService->getByStatus('DITOLAK');
        $semuaPermintaan = $rs->hasil->data;
        $permintaanBelumDiperiksa = $rs1->hasil->data;
        $permintaanDisetujui = $rs2->hasil->data;
        $permintaanDitolak = $rs3->hasil->data;
        // if ($request->ajax()) {
        //     return response()->json(array('permintaan' => $permintaan));
        // }
        return view('front_office.data_permintaan', [], [
            'semuaPermintaan' => $semuaPermintaan,
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
        $currentTime = Carbon::now();
        $hariIni = [];
        $mingguIni = [];
        $bulanIni = [];
        foreach ($bukuTamu as $bk) {
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $bk->check_in);
            $bk['filter'] = 'SEMUA';
            if (($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                // $bulanIni[] = $bk;
                $bk['filter'] = 'BULAN INI';
            }
            if (($cekWaktu->weekOfMonth == $currentTime->weekOfMonth) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                // $mingguIni[] = $bk;
                $bk['filter'] = 'MINGGU INI';
            }
            if (($cekWaktu->day == $currentTime->day) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                // $hariIni[] = $bk;
                $bk['filter'] = 'HARI INI';
            }
        }
        $data = [
            'semua' => $bukuTamu,
            // 'hariIni' => $hariIni,
            // 'mingguIni' => $mingguIni,
            // 'bulanIni' => $bulanIni
        ];
        // return response()->json($data);
        return view('front_office.data_buku_tamu', $data);
    }

    public function cetakBukuTamu($filter)
    {
        $rs = $this->bukuTamuService->getAll();
        $bukuTamu = $rs->hasil->data;
        $currentTime = Carbon::now();
        $hariIni = [];
        $mingguIni = [];
        $bulanIni = [];
        foreach ($bukuTamu as $bk) {
            $cekWaktu = Carbon::createFromFormat('Y-m-d H:i:s', $bk->check_in);
            $bk['filter'] = 'SEMUA';
            if (($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $bulanIni[] = $bk;
                $bk['filter'] = 'BULAN INI';
            }
            if (($cekWaktu->weekOfMonth == $currentTime->weekOfMonth) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $mingguIni[] = $bk;
                $bk['filter'] = 'MINGGU INI';
            }
            if (($cekWaktu->day == $currentTime->day) && ($cekWaktu->month == $currentTime->month) && ($cekWaktu->year == $currentTime->year)) {
                $hariIni[] = $bk;
                $bk['filter'] = 'HARI INI';
            }
        }
        $wc = new WaktuConverter($currentTime->toDateTimeString());
        $waktu = '';
        $tipe = '';
        switch ($filter) {
            case 'SEMUA':
                $tipe = 'Keseluruhan';
                break;
            case 'HARI INI':
                $tipe = 'Harian';
                $waktu = $wc->getDate();
                $bukuTamu = $hariIni;
                break;
            case 'MINGGU INI':
                $tipe = 'Mingguan';
                $tmp = Carbon::now();
                $tmp->addDays(- ($currentTime->dayOfWeek));
                $wc1 = new WaktuConverter($tmp->toDateTimeString());
                $low = $wc1->getDate();
                $tmp->addDays(6);
                $wc1 = new WaktuConverter($tmp->toDateTimeString());
                $high = $wc1->getDate();
                $waktu = $low . ' - ' . $high;
                $bukuTamu = $mingguIni;
                break;
            case 'BULAN INI':
                $tipe = 'Bulanan';
                $waktu = $wc->bulan . ' ' . $wc->tahun;
                $bukuTamu = $bulanIni;
                break;
        }
        $data = [
            'tipe' => $tipe,
            'waktu' => $waktu,
            'semua' => $bukuTamu,
        ];
        // return response()->json($data);
        $pdf = Pdf::loadView('laporan', $data);
        return $pdf->download();
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
        if ($rs->sukses) {
            $request->session()->put('nama', $rs->hasil->data->nama);
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        if ($rs->sukses) {
            $request->session()->put('username', $request->input('username'));
        }
        $tipe = $rs->sukses ? 'sukses' : 'gagal';
        Session::flash($tipe, $rs->pesan[0]);
        return response()->json($rs);
    }

    public function deleteBukuTamu(int $id)
    {
        $rs = $this->bukuTamuService->delete($id);
        return response()->json($rs);
    }
}
