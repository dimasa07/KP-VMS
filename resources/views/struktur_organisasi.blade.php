@extends('layouts.layout_main')

@section('title','Struktur Organisasi')

@section('content')
<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
            <h1 class="my-4 text-4xl font-bold leading-tight">
                Struktur Organisasi
            </h1>

            <!--Right Col-->
            <div class="w-full md:w-3/5 py-6 text-center">
                <img class="w-full md:w-4/5 z-50" src="" />
            </div>
        </div>
    </div>
</div>
@endsection