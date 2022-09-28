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

    public function updateAkun(Request $request)
    {
        $idAkun = $request->input('id');
        $akun = $this->akunService->getById($idAkun);
        $newUsername = $request->input('username');
        $cekAkun = $this->akunService->getByUsername($newUsername);
        if (!is_null($akun)) {
            if (is_null($cekAkun) || $akun->username == $newUsername) {
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
        } else {
            $resp['message'][] = 'Gagal update Akun, id tidak ditemukan';
        }

        return response()->json($resp);
    }

    public function updateTamu(Request $request)
    {
        $idTamu = $request->input('id');
        $tamu = $this->tamuService->getById($idTamu);
        $newNIK = $request->input('nik');
        $cekTamu = $this->tamuService->getByNIK($newNIK);
        if (!is_null($tamu)) {
            if (is_null($cekTamu) || $tamu->nik == $newNIK) {
                $update = $this->tamuService->update($idTamu, $request->input());
                if (is_null($update)) {
                    $resp['message'][] = 'Gagal update Tamu';
                    $resp['attributes'] = $request->input();
                } else {
                    $resp = [
                        'message' => 'Sukses update Tamu',
                        'tamu' => $update
                    ];
                }
            } else {
                $resp['message'][] = 'Gagal update Tamu, NIK telah tersedia';
            }
        } else {
            $resp['message'][] = 'Gagal update Tamu, id tidak ditemukan';
        }

        return response()->json($resp);
    }

    public function updatePegawai(Request $request)
    {
    }

    public function deleteAkun($id)
    {
        $akun = $this->akunService->getById($id);
        if (is_null($akun)) {
            $resp['message'][] = 'Gagal delete Akun, id tidak ditemukan';
        } else {
            $delete = $this->akunService->delete($id);
            if ($delete) {
                $resp = [
                    'message' => 'Sukses delete Akun',
                    'akun' => $akun
                ];
            } else {
                $resp['message'][] = 'Gagal delete Akun';
            }
        }

        return response()->json($resp);
    }

    public function deleteTamu($id)
    {
        $tamu = $this->tamuService->getById($id);
        if (is_null($tamu)) {
            $resp['message'][] = 'Gagal delete Tamu, id tidak ditemukan';
        } else {
            $delete = $this->tamuService->delete($id);
            $deleteAkun = $this->akunService->delete($tamu->id_akun);
            if ($delete) {
                $resp = [
                    'message' => 'Sukses delete Tamu',
                    'tamu' => $tamu
                ];
            } else {
                $resp['message'][] = 'Gagal delete Tamu';
            }
        }

        return response()->json($resp);
    }

    public function deletePegawai($id)
    {
        $pegawai = $this->pegawaiService->getById($id);
        if (is_null($pegawai)) {
            $resp['message'][] = 'Gagal delete Pegawai, id tidak ditemukan';
        } else {
            $delete = $this->pegawaiService->delete($id);
            $deleteAkun = $this->akunService->delete($pegawai->id_akun);
            if ($delete) {
                $resp = [
                    'message' => 'Sukses delete Pegawai',
                    'pegawai' => $pegawai
                ];
            } else {
                $resp['message'][] = 'Gagal delete Pegawai';
            }
        }

        return response()->json($resp);
    }
}
