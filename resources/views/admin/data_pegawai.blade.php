@extends('layouts.layout_admin')

@section('title','Admin - Data Pegawai')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="text-3xl font-bold uppercase text-gray-600">Data Pegawai</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="p-5" x-data="{ pegawai:null,showDetail:false }">
                    <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6">
                        <table class="w-full p-5 text-gray-700">
                            <tbody>
                                <tr>
                                    <td class="w-40">Nama Pegawai</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.nama"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">NIP</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.nip"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">Jabatan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.jabatan"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">No. Telepon</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.no_telepon"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Email</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.email"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Alamat</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.alamat"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Username</td>
                                    <td class="w-6">:</td>
                                    <td x-text="pegawai.akun.username"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="inline-flex absolute right-0 bottom-0" x-data="{ showConfirmSetuju : false }">
                            <!-- <button type="button" href="#" x-show="!showConfirmSetuju" @click="showConfirmSetuju= !showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>
                                <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                    <button type="button" x-show="showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a> -->
                            <button x-show="!showConfirmDelete" @click="showConfirmDelete= !showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Tamu</button>

                            <a x-bind:href="window.location.origin+'/admin/tamu/delete/'+tamu.id">
                                <button type="submit" @click="formData.id = permintaan.id;" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                            </a>
                            <button type="button" @click="showDetail= !showDetail; showConfirmDelete=false; showConfirmSetuju=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                        </div>
                    </div>
                    <table class="w-full p-5 text-gray-700 border-3 border-black" x-show="!showDetail">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Nama Pegawai</th>
                                <th class="border-2 text-blue-900 p-2">NIP</th>
                                <th class="border-2 text-blue-900 p-2">Jabatan</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($pegawai); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->nama }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->nip }}</td>
                                <td class="border-2 p-2">{{ $pegawai[$i]->jabatan }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="pegawai={{ $pegawai[$i] }}; showDetail= !showDetail" class="bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded">Detail</button>
                                    </div>
                                </td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</div>
@endsection