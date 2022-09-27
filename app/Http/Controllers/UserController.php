<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Tamu;
use App\Services\AdminService;
use App\Services\AkunService;
use App\Services\FrontOfficeService;
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
        $users = $this->akunService->getAll();
        foreach ($users as $user) {
            $user->tamu;
            $user->pegawai;
        }

        $jumlah = count($users);
        if ($jumlah == 0) {
            $resp['message'][] = 'Tidak ada data User';
        } else {
            $resp = [
                'message' => 'Data User ditemukan, jumlah ' . $jumlah . ' data',
                'users' => $users
            ];
        }
        return response()->json($resp);
    }

    public function getByNIK(string $nik)
    {
        $user = $this->userService->getByNIK($nik);
        if (is_null($user)) {
            $resp['message'][] = 'User dengan NIK tersebut tidak terdaftar';
        } else {
            $akun = $user->akun;
            $resp = [
                'message' => 'User ditemukan',
                'user' => $user
            ];
        }
        return response()->json($resp);
    }

    public function getByRole(string $role)
    {
        $users = $this->akunService->getByRole($role);
        $jumlah = count($users);
        if ($jumlah == 0) {
            $resp['message'][] = 'Tidak ada data User dengan Role ' . $role;
        } else {
            foreach ($users as $akun) {
                $akun = $akun->user;
            }
            $resp = [
                'message' => 'Data User dengan Role ' . $role . ' ditemukan, jumlah ' . $jumlah . ' data',
                'users' => $users
            ];
        }
        return response()->json($resp);
    }

    public function updateAdmin(Request $request)
    {
    }

    public function updateAkun(Request $request)
    {
        $idAkun = $request->input('id');
        if (is_null($this->akunService->getByUsername($request->input('username')))) {
            $update = $this->akunService->update($idAkun, $request->input());
            if (is_null($update)) {
                $resp['message'][] = 'Gagal update Akun';
                $resp['attributes'] = $request->input();
            } else {
                $resp = [
                    'message' => 'Sukses update Akun',
                    'akun' => $update
                ];
            }
        } else {
            $resp['message'][] = 'Gagal update Akun, Username telah tersedia';
        }

        return response()->json($resp);
    }

    public function updateTamu(Request $request)
    {
        // $idUser = $request->input('id');

        // if (is_null($this->akunService->getByUsername($request->input('username')))) {
        //     $update = $this->userService->update($idUser, $request->input());
        // }


        // if (is_null($update)) {
        //     $resp['message'][] = 'Gagal update User';
        //     $resp['attributes'] = $request->input();
        // } else {
        //     $resp = [
        //         'message' => 'Sukses update User',
        //         'user' => $update
        //     ];
        // }
        // return response()->json($resp);
    }

    public function updateFrontOffice(Request $request)
    {
    }

    public function updatePegawai(Request $request)
    {
    }

    public function deleteAdmin($id)
    {
    }

    public function deleteAkun($id)
    {
        $delete = $this->akunService->delete($id);
        if ($delete) {
            $resp['message'][] = 'Sukses delete Akun';
        } else {
            $resp['message'][] = 'Gagal delete Akun';
        }

        return response()->json($resp);
    }

    public function deleteTamu($id)
    {
        $delete = $this->tamuService->delete($id);
        if ($delete) {
            $resp['message'][] = 'Sukses delete Tamu';
        } else {
            $resp['message'][] = 'Gagal delete Tamu';
        }

        return response()->json($resp);
    }

    public function deleteFrontOffice($id)
    {
    }

    public function deletePegawai($id)
    {
    }
}
