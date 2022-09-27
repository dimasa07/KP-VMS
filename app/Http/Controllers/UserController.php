<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\User;
use App\Services\AkunService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(
        public UserService $userService,
        public AkunService $akunService
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
        $user = new User();
        $user->fill($request->input());

        if (!is_null($this->userService->getByNIK($user->nik))) {
            $resp['message'][] = 'Gagal daftar, NIK sudah terdaftar';
        } else {
            $user = $this->userService->save($user);
            $akun = new Akun();
            $akun->fill($request->input());
            $akun->id_user = $user->id;

            $akun = $this->akunService->save($akun);
            if (is_null($akun)) {
                $resp['message'][] = 'Gagal daftar, Username sudah terdaftar';
            } else {
                $resp = [
                    'message' => 'Sukses daftar',
                    'user' => $user,
                    'akun' => $akun
                ];
            }
        }

        return response()->json($resp);
    }

    public function allUser()
    {
        $users = $this->userService->getAll();
        foreach ($users as $user) {
            $user->akun;
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
}
