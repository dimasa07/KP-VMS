@extends('layouts.layout_front_office')

@section('title','Front Office - Buat Permintaan')

@section('content')
<!--Container-->
<div class="container w-full mx-auto pt-20">
    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <div class="border-b px-3 py-6">
                    <h5 class="ml-5 text-3xl font-bold uppercase text-gray-600">Buat Permintaan</h5>
                </div>
            </div>
        </div>

        <div class="w-full p-3">
            <!--Table Card-->
            <div class="bg-white border rounded shadow">
                <form method="POST" action="{{ route('fo.permintaan.tambah') }}">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Form Data Tamu</h5>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 relative">

                            <div class="px-5">
                                <div class="form-group mb-6">
                                    <label for="nama" class="form-label inline-block mb-2 text-gray-700">Nama Tamu</label>
                                    <input required type="text" class="form-control block w-full px-3 py-1.5 border border-gray-400" name="nama" id="nama">
                                    <!-- <small id="emailHelp" class="block mt-1 text-xs text-gray-600">We'll never share your email with anyone
                                        else.</small> -->
                                </div>
                                <div class="form-group mb-6">
                                    <label for="nik" class="form-label inline-block mb-2 text-gray-700">NIK</label>
                                    <input required name="nik" type="text" class="form-control block w-full px-3 py-1.5 border border-gray-400" id="nik">
                                </div>
                                <div class="form-group mb-6">
                                    <label for="no_telepon" class="form-label inline-block mb-2 text-gray-700">No. Telepon <small class=" mt-1 text-xs text-gray-600">(optional)</small></label>
                                    <input name="no_telepon" type="text" class="form-control block w-full px-3 py-1.5 border border-gray-400" id="no_telepon">
                                </div>

                            </div>

                            <div class="px-5">
                                <div class="form-group mb-6">
                                    <label for="email" class="form-label inline-block mb-2 text-gray-700">Email <small class=" mt-1 text-xs text-gray-600">(optional)</small></label>
                                    <input name="email" type="email" class="form-control block w-full px-3 py-1.5 border border-gray-400" id="email">

                                </div>
                                <div class="form-group mb-6 h-4/6 pb-14">
                                    <label for="alamat" class="form-label inline-block mb-2 text-gray-700">Alamat <small class=" mt-1 text-xs text-gray-600">(optional)</small></label></label>
                                    <textarea name="alamat" id="alamat" cols="50" class="max-h-full min-h-full form-control block w-full px-3 py-1.5 border border-gray-400"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Form Permintaan</h5>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 relative">
                            <div class="px-5">
                                <div class="form-group mb-6">
                                    <label for="pegawai" class="form-label inline-block mb-2 text-gray-700">Pegawai Dituju</label>
                                    <select name="id_pegawai" required class="bg-white form-control block w-full px-3 py-1.5 border border-gray-400" id="pegawai">
                                        @foreach($pegawai as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                    <!-- <small id="emailHelp" class="block mt-1 text-xs text-gray-600">We'll never share your email with anyone
                                        else.</small> -->
                                </div>
                                <div class="form-group mb-6">
                                    <label for="tanggal" class="form-label inline-block mb-2 text-gray-700">Tanggal</label>
                                    <input required name="tanggal" type="date" class="form-control block w-full px-3 py-1.5 border border-gray-400" id="tanggal">
                                </div>
                                <div class="form-group mb-6">
                                    <label for="waktu" class="form-label inline-block mb-2 text-gray-700">Waktu</label>
                                    <input required name="waktu" type="time" class="form-control block w-full px-3 py-1.5 border border-gray-400" id="waktu">
                                </div>

                            </div>

                            <div class="px-5">
                                <div class="form-group mb-6 h-full pb-14">
                                    <label for="keperluan" class="form-label inline-block mb-2 text-gray-700">Keperluan</label>
                                    <textarea required name="keperluan" id="keperluan" cols="50" class="max-h-full min-h-full form-control block w-full px-3 py-1.5 border border-gray-400"></textarea>
                                </div>

                            </div>

                        </div>
                        <div class="my-2 mx-5">
                            <button class="w-full py-2 bg-blue-600 hover:bg-blue-800 text-white px-2 rounded" type="submit" value="Kirim">Kirim</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var timepicker = new TimePicker('waktu', {
        lang: 'en',
        theme: 'dark'
    });
    timepicker.on('change', function(evt) {

        var value = ((evt.hour < 10) ? '0' + evt.hour : evt.hour || '00') + ':' + (evt.minute || '00');
        evt.element.value = value;

    });
</script>
@endsection