@extends('layouts.layout_admin')

@section('title','Admin - Akun')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="text-3xl font-bold uppercase text-gray-600">Akun</h5>
                </div>
            </div>
        </div>
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="p-5" x-data="{ showFormEdit : false }">
                    <div class="relative pb-11 px-6">
                        <table class="w-full p-5 text-gray-700" x-show="!showFormEdit">
                            <tbody>
                            <tr>
                                    <td class="w-40">Role</td>
                                    <td class="w-6">:</td>
                                    <td>{{ $akun->role }}</td>
                                </tr>
                                <tr>
                                    <td class="w-40">Username</td>
                                    <td class="w-6">:</td>
                                    <td>{{ $akun->username }}</td>
                                </tr>
                                <tr>
                                    <td class="w-40">Password</td>
                                    <td class="w-6">:</td>
                                    <td>{{ $akun->password }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="inline-flex absolute right-0 bottom-0">
                            <!-- <button type="button" href="#" x-show="!showConfirmSetuju" @click="showConfirmSetuju= !showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Setujui</button>
                                <a x-bind:href="window.location.origin+'/admin/permintaan/setujui/'+permintaan.id">
                                    <button type="button" x-show="showConfirmSetuju" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Konfirmasi Setuju</button></a> -->
                            <button x-show="!showFormEdit" @click="showFormEdit= !showFormEdit" class=" bg-blue-600 hover:bg-blue-800 text-white py-1 px-2 rounded mx-2">Edit Akun</button>

                            <a x-bind:href="window.location.origin+'/admin/akun/update'">
                                <button type="submit" @click="showFormEdit= !showFormEdit" x-show="showFormEdit" class=" bg-green-600 hover:bg-green-800 text-white py-1 px-2 rounded mx-2">Simpan Perubahan</button>
                            </a>
                            <button x-show="showFormEdit" type="button" @click="showFormEdit= !showFormEdit" class=" bg-gray-600 hover:bg-gray-800 text-white py-1 px-2 rounded mx-2">Batal</button>
                        </div>
                    </div>
                </div>

            </div>
            <!--/table Card-->
        </div>
    </div>
</div>
@endsection