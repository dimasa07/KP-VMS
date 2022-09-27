<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('buku_tamu')->delete();
        DB::table('permintaan_bertamu')->delete();
        DB::table('akun')->delete();
        DB::table('user')->delete();
        DB::table('pegawai')->delete();

        // SEED DATA ADMIN
        $admin = User::create([
            'nik' => 1,
            'nama' => 'Admin Diskominfo',
            'no_telepon' => '081234567891',
            'email' => 'admin@gmail.com'
        ]);
        $akunAdmin = Akun::create([
            'id_user' => $admin->id,
            'role' => 'ADMIN',
            'username' => 'admin',
            'password' => 'admin'
        ]);

        // SEED DATA FRONT OFFICE
        $fo = User::create([
            'nik' => 101,
            'nama' => 'FO Diskominfo',
            'no_telepon' => '081234567101',
            'email' => 'fo@gmail.com'
        ]);
        $akunFo = Akun::create([
            'id_user' => $fo->id,
            'role' => 'FRONT OFFICE',
            'username' => 'frontoffice',
            'password' => 'frontoffice'
        ]);

        // SEED DATA TAMU
        $tamu = User::create([
            'nik' => 1001,
            'nama' => 'TAMU 1',
            'no_telepon' => '081234561001',
            'email' => 'tamu@gmail.com'
        ]);
        $akunTamu = Akun::create([
            'id_user' => $tamu->id,
            'role' => 'TAMU',
            'username' => 'tamu',
            'password' => 'tamu'
        ]);

        // SEED DATA Pegawai
        $pegawai = Pegawai::create([
            'nik' => 10001,
            'nama' => 'Pegawai 1',
            'no_telepon' => '081234510001',
            'email' => 'pegawai@gmail.com'
        ]);
        $pegawai2 = Pegawai::create([
            'nik' => 10002,
            'nama' => 'Pegawai 2',
            'no_telepon' => '081234510002',
            'email' => 'pegawai2@gmail.com'
        ]);
        $pegawai = Pegawai::create([
            'nik' => 10003,
            'nama' => 'Pegawai 3',
            'no_telepon' => '081234510003',
            'email' => 'pegawai3@gmail.com'
        ]);
    }
}
