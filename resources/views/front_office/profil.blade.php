@extends('layouts.layout_front_office')

@section('title','Front Office - Profil')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Profil</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="p-5" x-data="{ showFormEdit : false, frontOffice:{{$frontOffice}} }">
                    @if($pesan = Session::get('gagal'))
                    <div class="bg-red-500 text-white w-full text-center rounded mb-6 p-4">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div class="bg-green-500 text-white w-full text-center rounded mb-6 p-4">
                        {{ $pesan }}
                    </div>
                    @endif
                    <form method="POST" @submit.prevent="submit()">
                        <div class="relative pb-11 px-6">
                            <table class="w-full p-5 text-gray-700" x-show="!showFormEdit">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Front Office</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIP</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->nip }}</td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">Jabatan</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->jabatan }}</td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->no_telepon }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td>{{ $frontOffice->alamat }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table style="display: none;" class="w-full p-5 text-gray-700" x-show="showFormEdit">
                                <tbody>
                                    <tr>
                                        <td class="w-40">Nama Admin</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.nama" class="px-1 border border-gray-600" type="text" name="nama" :value="frontOffice.nama"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">NIP</td>
                                        <td class="w-6">:</td>
                                        <td><input disabled x-model="formData.nip" class="px-1 border border-gray-600" type="text" name="nip" :value="frontOffice.nip"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">Jabatan</td>
                                        <td class="w-6">:</td>
                                        <td><input disabled x-model="formData.jabatan" class="px-1 border border-gray-600" type="text" name="jabatan" :value="frontOffice.jabatan"></td>

                                    </tr>
                                    <tr>
                                        <td class="w-40">No. Telepon</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.no_telepon" class="px-1 border border-gray-600" type="text" name="no_telepon" :value="frontOffice.no_telepon"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Email</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.email" class="px-1 border border-gray-600" type="text" name="email" :value="frontOffice.email"></td>
                                    </tr>
                                    <tr>
                                        <td class="w-40">Alamat</td>
                                        <td class="w-6">:</td>
                                        <td><input required x-model="formData.alamat" class="px-1 border border-gray-600" type="text" name="alamat" :value="frontOffice.alamat"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="inline-flex absolute right-0 bottom-0">
                                <!-- <button type="button" href="#" x-show="!showConfirmSetuju" @click="showConfirmSetuju= !showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>
                                <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                    <button type="button" x-show="showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a> -->
                                <button type="button" x-show="!showFormEdit" @click="showFormEdit= !showFormEdit; frontOffice={{$frontOffice}}" class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit Profil</button>

                                <!-- <a x-bind:href="window.location.origin+'/admin/profil/update'"> -->
                                <button style="display: none;" type="submit" @click="formData.id=frontOffice.id; formData.nip=frontOffice.nip" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button>
                                <!-- </a> -->
                                <button style="display: none;" x-show="showFormEdit" type="button" @click="showFormEdit= !showFormEdit" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--/table Card-->
        </div>
    </div>
</div>
<script>
    function submit() {
        $.ajax({
            type: 'POST',
            url: window.location.origin + "/fo/profil/update",
            data: {
                'id': formData.id,
                'nama': formData.nama,
                'nip': formData.nip,
                'jabatan': formData.jabatan,
                'no_telepon': formData.no_telepon,
                'email': formData.email,
                'alamat': formData.alamat
            },
            success: function(success) {
                // console.log("sukses");
                location.reload();
            },
            error: function(error) {
                console.log(error);
                // document.body.innerHTML = success;
                // location.reload();
            }
        });
    }

    function formData() {
        return {
            formData: {
                id: 0,
                nama: '',
                nip: '',
                jabatan: '',
                no_telepon: '',
                email: '',
                alamat: ''
            }
        }
    }
</script>
@endsection