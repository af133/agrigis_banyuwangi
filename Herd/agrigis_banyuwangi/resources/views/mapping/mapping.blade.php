@extends('layout.app')
@section('title','Mapping')

@section('content')
@php
$dataUser=session('dataUser')
@endphp
        <h1 class="px-10 pt-4 text-[#0E5509] font-bold text-[clamp(1.4rem,2vw,3rem)]">Mapping</h1>
        <div class="w-full mt-1 h-2 bg-[#DDFFAC]"></div>

        <!-- Tombol tambah -->
        @if ($dataUser['status']=='Staf')
        
        <button id="addBtn" class="z-2 absolute top-34 cursor-pointer right-5 bg-[#DDFFAC] text-[#554009] p-2 rounded-lg shadow-lg hover:bg-[#eaffcd] transition duration-200">
            Tambah Titik
        </button>
        <div class="controls hidden" id="controlDraw">
        <button id="createPolygonBtn" class=" z-2 mt-3 ml-2 cursor-pointer right-10 bg-[#DDFFAC] text-[#554009] p-2 rounded-lg shadow-lg hover:bg-[#eaffcd] transition duration-200">Buat Poligon</button>
        <button id="editPolygonBtn" class=" z-2 mt-3 ml-2 cursor-pointer right-10 bg-[#DDFFAC] text-[#554009] p-2 rounded-lg shadow-lg hover:bg-[#eaffcd] transition duration-200">Edit Poligon</button>
        <button id="savePolygonBtn" class=" z-2 mt-3 ml-2 cursor-pointer right-10 bg-[#DDFFAC] text-[#554009] p-2 rounded-lg shadow-lg hover:bg-[#eaffcd] transition duration-200">Simpan
            @csrf
        </button>
        <button onclick="cancelDraw()" class=" z-2 mt-3 ml-2 cursor-pointer right-10 bg-[#DDFFAC] text-[#554009] p-2 rounded-lg shadow-lg hover:bg-[#eaffcd] transition duration-200" type="button">Batal</button>
        </div>
        @else
        <div id="addBtn"  ></div>
        @endif
        <div id="map" class="mt-4 lg:m-4 m-0 rounded-2xl w-ful h-[90dvh] z-1 border-2 border-[#0E5509]"></div>

    <form id="formBox" action="{{ route('mapping.store') }}" method="POST"
        class="z-5 hidden absolute top-23 ml-10 bg-[#F1FFDE] lg:text-[1rem] text-[0.6rem] p-2 border rounded-lg w-fit">
        @csrf
        <table class="table-auto text-left w-full">

            {{-- Petani --}}
            <tr class="border-b border-gray-500">
                <td><label for="namaPetani" class="p-1">Nama Petani</label></td>
                <td>:</td>
                <td><input type="text" name="namaPetani" id="namaPetani" class="ml-2  px-2 py-1 rounded" required></td>
            </tr>

            {{-- Nomor Telepon --}}
            <tr class="border-b border-gray-500">
                <td><label for="nmr_telpon" class="p-1">Nomor Telepon</label></td>
                <td>:</td>
                <td><input type="text" name="nmr_telpon" id="nmr_telpon" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>

            {{-- NIK --}}
            <tr class="border-b border-gray-500">
                <td><label for="nik" class="p-1">NIK</label></td>
                <td>:</td>
                <td><input type="text" name="nik" id="nik" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>


            {{-- Alamat --}}
            <tr class="border-b border-gray-500">
                <td><label for="alamat" class="p-1">Alamat</label></td>
                <td>:</td>
                <td><input type="text" name="alamat" id="alamat" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>

            {{-- Jenis Tanaman --}}

            <tr class="border-b border-gray-500">
                <td><label for="namaTanaman" class="p-1">Nama Tanaman</label></td>
                <td>:</td>
                <td><input type="text" name="namaTanaman" id="nama_tanaman" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>

            {{-- Luas Lahan --}}
            <tr class="border-b border-gray-500">
                <td><label for="luasLahan" class="p-1">Luas Lahan</label></td>
                <td>:</td>
                <td><input type="number" name="luasLahan" id="luas_lahan" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>


            {{-- Latitude --}}
            <tr class="border-b border-gray-500">
                <td><label for="lat" class="p-1">Latitude</label></td>
                <td>:</td>
                <td><input type="number" name="lat" id="lat" step="any" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>

            {{-- Longitude --}}
            <tr class="border-b border-gray-500">
                <td><label for="lng" class="p-1">Longitude</label></td>
                <td>:</td>
                <td><input type="number" name="lng" id="lng" step="any" class="ml-2 px-2 py-1 rounded" required></td>
            </tr>

            {{-- Jenis Lahan --}}
            <tr class="border-b border-gray-500">
                <td><label for="statusLahan" class="p-1">Status Lahan</label></td>
                <td>:</td>
                <td>
                    <select name="statusLahan" id="jenis_lahan_id" class="ml-2 w-full px-2 py-1 rounded" required>
                        <option disabled selected>Pilih Status</option>
                        @foreach($jenisLahanList as $lahan)
                            <option value="{{$lahan->id}}">{{$lahan->jenis_lahan}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>


            {{-- Status Tanam --}}
            <tr class="border-b border-gray-500">
                <td><label for="statusPanen" class="p-1">Status Tanam</label></td>
                <td>:</td>
                <td>
                    <select name="statusPanen" id="status_tanam" class="ml-2 w-full px-2 py-1 rounded" required>
                        <option disabled selected>Pilih Status</option>
                        <option value="Tanam">Tanam</option>
                        <option value="Panen">Panen</option>
                    </select>
                </td>
            </tr>
        </table>

        <div class="mt-4 text-right flex">
            <div class="flex-1 p-2 justify-start flex">
                <button type="submit" id="submitButton" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            </div>
            <div class="flex-1 p-2 justify-start">
                <button id="closeBtn"  onclick="closeForm()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Batal</button>

            </div>
        </div>
    </form>
    <input type="hidden" id="koordinatPoligon" name="koordinatPoligon" />

    <script>
        function cancelDraw() {
            window.location.reload();
        }
         window.userStatus = @json($dataUser['status']);
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("formBox").style.display = 'none';
        });
        function closeForm() {
            document.getElementById("formBox").style.display = 'none';
        }
    </script>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection
