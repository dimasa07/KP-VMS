@extends('layouts.layout_admin')

@section('title','Admin - Data Permintaan Bertamu')

@section('content')
<script>
    function submit() {
        console.log("asjd");
        var req = new XMLHttpRequest();
        req.open("POST", window.location.origin + "/admin/permintaan/tolak", true);
        req.setRequestHeader('Content-Type', 'application/json');
        req.send();
    }

    // function getData(){
    //  return {
    //     formData:{
    //         id:'',
    //         pesan_ditolak:''
    //     }
    //  }   
    // }
</script>
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
        <div class="w-full p-3" x-data="{ showDetail: false }">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{ permintaan: null }">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Belum Diperiksa</h5>
                </div>
                <div class="p-5">
                    <div style="display: none;" x-show="showDetail" class="relative pb-11 px-6" x-data="{ konfirmasiTolak:false }">
                            <div x-data="{ pesan_ditolak:'' }">
                                <table class="w-full p-5 text-gray-700">
                                    <tbody>
                                        <tr>
                                            <td class="w-40">Nama Tamu</td>
                                            <td class="w-6">:</td>
                                            <td x-text="permintaan.tamu.nama"></td>
                                            <td rowspan="7" class="text-right w-fit">
                                                <textarea x-model="pesan_ditolak" x-show="konfirmasiTolak" style="display:none" class="border-2 p-2" placeholder="Pesan ditolak..." id="pesan_ditolak" rows="6" cols="50" value="-"></textarea>
                                            </td>
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
                                    </tbody>
                                </table>
                                <div class="inline-flex absolute right-0 bottom-0" x-data="{ konfirmasiSetuju : false }">
                                    <button x-show="!konfirmasiSetuju" @click="konfirmasiSetuju= !konfirmasiSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>

                                    <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                        <button x-show="konfirmasiSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a>
                                    <button x-show="!konfirmasiTolak" @click="konfirmasiTolak= !konfirmasiTolak" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Tolak</button>
                                    <a x-bind:href="window.location.origin+'/admin/permintaan/tolak/'+permintaan.id+'?pesanDitolak='+pesan_ditolak">
                                        <button type="submit" x-show="konfirmasiTolak" class=" bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded mx-2">Konfimasi Tolak</button>
                                    </a>
                                    <button @click="showDetail= !showDetail; konfirmasiTolak=false; konfirmasiSetuju=false" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Tutup</button>
                                </div>
                            </div>
                    </div>
                    <table x-show="!showDetail" class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-blue-900 p-2">NIK</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Waktu Permintaan</th>
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
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="permintaan={{ $permintaanBelumDiperiksa[$i] }}; showDetail= !showDetail" class="bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded">Detail</button>
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
        <div class="w-full p-3" x-data="{ showDetail: false }">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{ permintaan: null }">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Disetujui</h5>
                </div>
                <div class="p-5">
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
                                    <td class="w-40">Waktu Pemeriksaan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.waktu_pemeriksaan"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Admin Pemeriksa</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.admin.nama"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Status</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.status"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button @click="showDetail= !showDetail" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded absolute right-0 bottom-0">Tutup</button>
                    </div>
                    <table x-show="!showDetail" class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-blue-900 p-2">NIK</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Waktu Pemeriksaan</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaanDisetujui); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->tamu->nik }}</td>
                                <td class="border-2 p-2">{{ $permintaanDisetujui[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2 text-center">{{ $permintaanDisetujui[$i]->waktu_pemeriksaan }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="permintaan={{ $permintaanDisetujui[$i] }}; showDetail= !showDetail" class="bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded">Detail</button>
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
        <div class="w-full p-3" x-data="{ showDetail: false }">
            <!--Table Card-->
            <div class="bg-white border rounded shadow" x-data="{ permintaan: null }">
                <div class="border-b p-3">
                    <h5 class="font-bold uppercase text-gray-600">Ditolak</h5>
                </div>
                <div class="p-5">
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
                                    <td class="w-40">Waktu Pemeriksaan</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.waktu_pemeriksaan"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Admin Pemeriksa</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.admin.nama"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Status</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.status"></td>
                                </tr>
                                <tr>
                                    <td class="w-40">Pesan Ditolak</td>
                                    <td class="w-6">:</td>
                                    <td x-text="permintaan.pesan_ditolak"></td>
                                </tr>
                            </tbody>
                        </table>
                        <button @click="showDetail= !showDetail" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded absolute right-0 bottom-0">Tutup</button>
                    </div>
                    <table x-show="!showDetail" class="w-full p-5 text-gray-700 border-3 border-black">
                        <thead>
                            <tr>
                                <th class="border-2 text-blue-900 p-2">No</th>
                                <th class="border-2 text-blue-900 p-2">Nama Tamu</th>
                                <th class="border-2 text-blue-900 p-2">NIK</th>
                                <th class="border-2 text-blue-900 p-2">Pegawai dituju</th>
                                <th class="border-2 text-blue-900 p-2">Waktu Pemeriksaan</th>
                                <th class="border-2 text-blue-900 p-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @for($i = 0 ; $i < count($permintaanDitolak); $i++) <tr>
                                <td class="border-2 p-2 text-center">{{ $i+1 }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->tamu->nama }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->tamu->nik }}</td>
                                <td class="border-2 p-2">{{ $permintaanDitolak[$i]->pegawai->nama }}</td>
                                <td class="border-2 p-2 text-center">{{ $permintaanDitolak[$i]->waktu_pemeriksaan }}</td>
                                <td class="border-2 p-2 text-center">
                                    <div>
                                        <button @click="permintaan={{ $permintaanDitolak[$i] }}; showDetail= !showDetail" class="bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded">Detail</button>
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