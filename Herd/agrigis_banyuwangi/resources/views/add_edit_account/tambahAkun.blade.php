@extends('layout.app')
@section('content')
@section('title','Tambah Akun')

<h1 class="px-10 pt-4 text-[#0E5509] font-bold text-[clamp(1.4rem,2vw,3rem)]">Tambah Akun</h1>
<div class="w-full mt-1 h-2 bg-[#DDFFAC] mb-10"></div>

<div class="flex justify-center">
    <div class="bg-white w-[60%] shadow-lg rounded-lg p-8">

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

@error('email')
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ $message }}
    </div>
@enderror

        <form id="akunForm" action="{{ route('userss.store') }}" method="POST" class="space-y-5 " enctype="multipart/form-data">
            @csrf

            <div>
                <label class="block text-sm text-gray-600 mb-1">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                       value="{{ old('email') }}">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Status</label>
                <select name="status_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
                    @foreach ($statusPekerjaan as $status)
                        <option value="{{ $status['id'] }}" {{ old('status_id') == $status['id'] ? 'selected' : '' }}>
                            {{ $status['status'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
{{-- Popup Konfirmasi --}}
<div id="popupConfirm"
     class="fixed inset-0 bg-gray-800/25 flex items-center justify-center z-50 hidden">
    <div class="relative w-full max-w-md mx-auto p-4">
        <div class="bg-[#DDFFAC] text-center p-6 rounded-lg shadow-md border border-green-300">
            <p class="text-lg font-medium text-green-900">
                Apakah data yang ditambahkan sudah sesuai?
            </p>
        </div>
        <div class="flex justify-center gap-6 mt-4">
            <button id="cancelPopup" type="button"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-2 rounded-md">
                Cek Ulang
            </button>
            <button id="confirmPopup" type="button"
                class="bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-2 rounded-md">
                Ya
            </button>
        </div>
    </div>
</div>
{{-- Popup Sukses --}}
<div id="successPopup"
     class="fixed inset-0 flex items-center justify-center bg-green-100/50 z-40 hidden">
    <div class="bg-[#DDFFAC] px-8 py-4 rounded-lg shadow-lg text-black font-semibold">
        Akun berhasil dibuat
    </div>
</div>
@if (session('akun_success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const successPopup = document.getElementById("successPopup");
            if (successPopup) {
                successPopup.classList.remove("hidden");

                setTimeout(() => {
                    successPopup.classList.add("hidden");
                }, 2000);
            }
        });
    </script>
@endif
<script>
    const form = document.getElementById('akunForm');
    const popup = document.getElementById('popupConfirm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        popup.classList.remove('hidden'); 
    });

    document.getElementById('cancelPopup').addEventListener('click', () => {
        popup.classList.add('hidden'); 
    });

    document.getElementById('confirmPopup').addEventListener('click', () => {
        popup.classList.add('hidden');
        form.submit();
    });
</script>

@endsection