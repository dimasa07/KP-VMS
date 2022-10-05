@extends('layouts.layout_main')

@section('title','Visi dan Misi')

@section('content')
<div class="pt-24">
    <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
        <!--Left Col-->
        <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
            <h1 class="my-4 text-4xl font-bold leading-tight">
                Visi dan Misi
            </h1>
            <span class="leading-normal text-2xl ml-20 underline">
                Visi
            </span>
            <ul class="list-disc ml-28">
                <li>Visi 1</li>
                <li>Visi 2</li>
                <li>Visi 3</li>
                <li>Visi 4</li>
                <li>Visi 5</li>
            </ul>
            <span class="leading-normal text-2xl mt-10 ml-20 underline">
                Misi
            </span>
            <ul class="list-disc ml-28">
                <li>Misi 1</li>
                <li>Misi 2</li>
                <li>Misi 3</li>
                <li>Misi 4</li>
                <li>Misi 5</li>
            </ul>
            <!--Right Col-->
            <div class="w-full md:w-3/5 py-6 text-center">
                <img class="w-full md:w-4/5 z-50" src="" />
            </div>
        </div>
    </div>
</div>
@endsection