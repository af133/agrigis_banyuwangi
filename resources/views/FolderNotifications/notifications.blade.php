@extends('layout.app')
@section('title','Notifikasi')

@section('content')
    {{-- Header Notifikasi --}}
    <div class="bg-[#F1FFD8] border-b-4 border-[#D3FF9E] px-6 py-4">
        <h2 class="text-2xl font-bold text-green-900">Notifikasi</h2>
    </div>

    {{-- Isi Notifikasi --}}
    <div class="p-6">
        @if(session('report'))
            @foreach(session('report') as $notif)
                <div class="bg-[#DDFFAC] rounded-xl p-3 mb-4 cursor-pointer hover:bg-green-300 transition"
                    onclick="window.location.href='{{ route('gotoMapping', ['lat' => $notif['lat'], 'lng' => $notif['lng']]) }}'">

                    {{-- Baris nama staf dan waktu --}}
                    <div class="flex justify-between items-center">
                        <div class="font-semibold">{{ $notif['namaStaf'] }}</div>
                        <div class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($notif['waktu_laporan'])->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Isi pesan --}}
                    <div>baru saja menambahkan data lapangan</div>
                </div>
            @endforeach
        @else
            <p>Tidak ada notifikasi.</p>
        @endif
    </div>
@endsection