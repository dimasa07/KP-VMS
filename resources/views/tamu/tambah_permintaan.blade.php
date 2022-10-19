@extends('layouts.layout_tamu')

@section('title','Tamu - Buat Permintaan')

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

                @if(session()->get('id')==0)
                <div class="p-5">
                    <h3 class="text-1xl">Isi <a class="text-blue-800 underline" href="{{ route('tamu.profil') }}">profil</a> terlebih dahulu untuk bisa membuat permintaan.</h3>
                </div>
                @else
                <div class="p-5">
                    @if($pesan = Session::get('gagal'))
                    <div class="bg-red-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    @if($pesan = Session::get('sukses'))
                    <div class="bg-green-500 text-white w-full text-center rounded mb-6 p-1">
                        {{ $pesan }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('tamu.permintaan.tambah') }}">
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
                            <button class="w-full py-2 bg-teal-700 hover:bg-teal-900 text-white px-2 rounded" type="submit" value="Kirim">Kirim</button>
                        </div>
                    </form>
                </div>
                @endif
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