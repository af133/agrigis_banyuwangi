@extends('layout.app')
@section('title','Login Agrigis')
@section('content') 

<div
  class="h-[7rem] bg-cover bg-center"
  style="background-image: url('{{ asset('icons/sawa.png') }}');"
></div>

<div class="text-[#021D00] items-center flex justify-center m-[1rem]">
    <img src="{{ asset('icons/logo.png') }}" alt="#" class="w-[7rem] ml-2">
    <h1 class="font-bold text-[clamp(1.2rem,2.3vw,3.3rem)]">Banyuwangi AgriGIS</h1> 
</div>


<div class="flex justify-center w-full items-center mb-10">
    <section class="bg-[#DDFFAC] w-[clamp(16rem,50vw,23rem)] rounded-2xl shadow-xl flex justify-center text-[#0E5509] p-5 
    
    ">
        <form action="login" method="post" class="flex flex-col w-full">
        @csrf
        <p class="text-center font-bold text-[4dvh] mb-4">Masuk</p>
        <label for="email" class="mb-1">Email</label>
        <input type="text" name="name" id="email" class=" p mb-3 border rounded px-2 py-1   " 
        value="{{ old('name') }}"
        placeholder="{{ $errors->first('name')}}"  
        >

        <label for="password" class="mb-1">Password</label>
        <input type="password" name="password" id="password" class="mb-3 border rounded px-2 py-1" placeholder="{{$errors->first('password')  }}" >

        <button type="submit" class="bg-[#0E5509] hover:bg-[#3d6d39] text-white font-bold rounded px-3 py-1 transition duration-300">
            Submit
        </button>
        @if (session('error'))
        <div class="text-red-500 mt-2">
            {{ session('error') }}
        </div>
        @endif
    </form>
</div>


@endsection
