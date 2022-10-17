@extends('layouts.layout_tamu')

@section('title','Tamu - Riwayat Permintaan')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Riwayat Permintaan</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="p-5" x-data="{ permintaan:null,showDetail:false }">
                    <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6">
                        <table class="w-full p-5 text-gray-700">
                            <tbody>
                                <tr>
                                    <td class="w-40">Nama Tamu</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.tamu.nama"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">NIK</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.tamu.nik"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">Pegawai Dituju</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.pegawai.nama"></td>

                                </tr>
                                <tr>
                                    <td class="w-40">Keperluan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.keperluan"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Waktu Bertamu</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.waktu_bertamu"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Waktu Pengiriman</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.waktu_pengiriman"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Status</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.status"></td>
                                </tr>
                                <tr x-show="permintaan.status =='DITOLAK'">
                                    <td class="w-40">Pesan Ditolak</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.pesan_ditolak"></td>
                                </tr>
                                <tr x-show="permintaan.status != 'BELUM DIPERIKSA'">
                                    <td class="w-40">Admin Pemeriksa</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.admin.nama"></td>
                                </tr>
                                <tr x-show="permintaan.status != 'BELUM DIPERIKSA'">
                                    <td class="w-40">Waktu Pemeriksaan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.waktu_pemeriksaan"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="inline-flex absolute right-0 bottom-0" x-data="{ showConfirmSetuju : false }">
                            <!-- <button type="button" href="#" x-show="!showConfirmSetuju" @click="showConfirmSetuju= !showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>
                                <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                    <button type="button" x-show="showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a> -->
                            <!-- <button x-show="!showConfirmDelete" @click="showConfirmDelete= !showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Hapus Tamu</button>

                            <a x-bind:href="window.location.origin+'/admin/tamu/delete/'+tamu.id">
                                <button type="submit" @click="formData.id = permintaan.id;" x-show="showConfirmDelete" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Hapus</button>
                            </a> -->
                            <button type="button" @click="showDetail= !showDetail" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                        </div>
                    </div>


                    <table x-show="!showDetail" class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-teal-900 p-2">No</th>
                                <th class="border-2 text-teal-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-teal-900 p-2">NIK</th>
                                <th class="border-2 text-teal-900 p-2">Pegawai Dituju</th>
                                <th class="border-2 text-teal-900 p-2">Waktu Pengiriman</th>
                                <th class="border-2 text-teal-900 p-2">Status</th>
                                <th class="border-2 text-teal-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaan); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaan[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaan[$i]->tamu->nik }}</td>
                                <td class="border-2 p-2">{{ $permintaan[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaan[$i]->waktu_pengiriman }}</td>
                                <td class="border-2 p-2">{{ $permintaan[$i]->status }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="permintaan={{ $permintaan[$i] }}; showDetail= !showDetail" class="bg-teal-700 hover:bg-teal-900 text-white py-1 px-2 rounded">Detail</button>
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