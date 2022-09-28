<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Tamu;
use App\Services\AkunService;
use App\Services\PegawaiService;
use App\Services\TamuService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        public AkunService $akunService,
        public TamuService $tamuService,
        public PegawaiService $pegawaiService
    ) {
    }

    public function formLogin(Request $request)
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $akun = $this->akunService->getByUsernameAndPassword($username, $password);
        if (!is_null($akun)) {
            $request->session()->put('username', $akun->username);
            $request->session()->put('role', $akun->role);
            $resp = [
                'message' => 'Sukses login',
                'akun' => $akun
            ];
        } else {
            $resp = [
                'message' => 'Gagal login'
            ];
        }

        return response()->json($resp);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('username');
        $request->session()->forget('role');
    }

    public function daftar(Request $request)
    {
        $tamu = new Tamu();
        $tamu->fill($request->input());

        if (!is_null($this->tamuService->getByNIK($tamu->nik))) {
            $resp['message'][] = 'Gagal daftar, NIK sudah terdaftar';
        } else {
            $akun = new Akun();
            $akun->fill($request->input());

            $akun = $this->akunService->save($akun);
            if (is_null($akun)) {
                $resp['message'][] = 'Gagal daftar, Username sudah terdaftar';
            } else {
                $tamu->id_akun = $akun->id;
                $tamu = $this->tamuService->save($tamu);
                $resp = [
                    'message' => 'Sukses daftar',
                    'tamu' => $tamu,
                    'akun' => $akun
                ];
            }
        }

        return response()->json($resp);
    }

    public function allUser()
    {
        $rs = $this->akunService->getAll();
        return response()->json($rs);
    }

    public function getByRole(string $role)
    {
        $rs = $this->akunService->getByRole($role);
        return response()->json($rs);
    }

    public function updateAkun(Request $request)
    {
        $rs = $this->akunService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updateTamu(Request $request)
    {
        $rs = $this->tamuService->update($request->input('id'), $request->input());
        return response()->json($rs);
    }

    public function updatePegawai(Request $request)
    {
    }

    public function deleteAkun($id)
    {
        $rs = $this->akunService->delete($id);
        return response()->json($rs);
    }

    public function deleteTamu($id)
    {
        $rs = $this->tamuService->delete($id);
        return response()->json($rs);
    }

    public function deletePegawai($id)
    {
        $rs = $this->pegawaiService->delete($id);
        return response()->json($rs);
    }
}
