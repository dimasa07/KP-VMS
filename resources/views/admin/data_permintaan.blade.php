@extends('layouts.layout_admin')

@section('title','Admin - Data Permintaan Bertamu')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="text-3xl font-bold uppercase text-gray-600">Data Permintaan Bertamu</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Belum Diperiksa</h5>
                </div>
                <div class="p-5">
                    <table class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-blue-900 p-2">NIK</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Pengiriman Permintaan</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaanBelumDiperiksa); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaanBelumDiperiksa[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanBelumDiperiksa[$i]->tamu->nik }}</td>
                                <td class="border-2 p-2">{{ $permintaanBelumDiperiksa[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2 text-center">{{ $permintaanBelumDiperiksa[$i]->waktu_pengiriman }}</td>
                                <td class="border-2 p-2 text-center"></td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/table Card-->
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Disetujui</h5>
                </div>
                <div class="p-5">
                    <table class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Tamu</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Keperluan</th>
                                <th class="border-2 text-blue-900 p-2">Waktu</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaanDisetujui); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->keperluan }}</td>
                                <td class="border-2 p-2 text-center">{{ $permintaanDisetujui[$i]->waktu_bertamu }}</td>
                                <td class="border-2 p-2 text-center"></td>
                                </tr>
                                @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/table Card-->
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Ditolak</h5>
                </div>
                <div class="p-5">
                    <table class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Tamu</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Keperluan</th>
                                <th class="border-2 text-blue-900 p-2">Waktu</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaanDitolak); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->keperluan }}</td>
                                <td class="border-2 p-2 text-center">{{ $permintaanDitolak[$i]->waktu_bertamu }}</td>
                                <td class="border-2 p-2 text-center"></td>
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