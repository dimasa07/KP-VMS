<?php

namespace App\Services;

use App\Models\BukuTamu;

class BukuTamuService
{
    public function save(BukuTamu $bukuTamu)
    {
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        $sukses = $bukuTamu->save();
        $rs->sukses = $sukses;
        if ($sukses) {
            $rs->pesan[] = 'Sukses tambah Buku Tamu';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data = $bukuTamu;
        } else {
            $rs->pesan[] = 'Gagal tambah Buku Tamu';
        }

        return $rs;
    }

    public function getAll()
    {
        $bukuTamu = BukuTamu::all();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Array';
        $jumlah = count($bukuTamu);
        $rs->hasil->jumlah = $jumlah;
        if ($jumlah == 0) {
            $rs->pesan[] = 'Tidak ada data Buku Tamu';
        } else {
            $rs->sukses = true;
            foreach ($bukuTamu as $bt) {
                $bt->admin;
                $bt->pegawai;
                $bt->tamu;
            }
            $rs->pesan[] = 'Data Buku Tamu ditemukan';
        }
        $rs->hasil->data = $bukuTamu;

        return $rs;
    }

    public function getById($id)
    {
        $bukuTamu = BukuTamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($bukuTamu)) {
            $rs->pesan[] = 'Buku Tamu dengan id ' . $id . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Buku Tamu ditemukan';
            $rs->hasil->data = $bukuTamu;
        }
        return $rs;
    }

    public function getByIdPermintaan($idPermintaan)
    {
        $bukuTamu = BukuTamu::where('id_permintaan', '=', $idPermintaan)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($bukuTamu)) {
            $rs->pesan[] = 'Buku Tamu dengan id ' . $idPermintaan . ' tidak terdaftar';
        } else {
            $rs->sukses = true;
            $rs->hasil->jumlah = 1;
            $rs->pesan[] = 'Buku Tamu ditemukan';
            $rs->hasil->data = $bukuTamu;
        }
        return $rs;
    }

    public function update($id, $attributes = [])
    {
        $bukuTamu = BukuTamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (!is_null($bukuTamu)) {
            $update = $bukuTamu->update($attributes);
            $rs->sukses = true;
            $rs->pesan[] = 'Sukses update Buku Tamu';
            $rs->hasil->jumlah = 1;
            $rs->hasil->data = $bukuTamu;
        } else {
            $rs->pesan[] = 'Gagal update Buku Tamu, id tidak ditemukan';
        }

        return $rs;
    }

    public function delete($id)
    {
        $bukuTamu = BukuTamu::where('id', '=', $id)->first();
        $rs = new ResultSet();
        $rs->hasil->tipe = 'Object';
        if (is_null($bukuTamu)) {
            $rs->pesan[] = 'Gagal delete Buku Tamu, id tidak ditemukan';
        } else {
            $delete = $bukuTamu->delete();
            if ($delete) {
                $rs->sukses = true;
                $rs->pesan[] = 'Sukses delete Buku Tamu';
                $rs->hasil->jumlah = 1;
            } else {
                $rs->pesan[] = 'Gagal delete Buku Tamu';
            }
        }
        $rs->hasil->data = $bukuTamu;
        return $rs;
    }
}
