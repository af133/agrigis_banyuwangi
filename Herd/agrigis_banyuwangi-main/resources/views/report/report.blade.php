@extends('layout.app')
@section('content')
<div class="p-4 md:p-8">
    <h1 class="text-[#0E5509] font-bold text-[clamp(1.4rem,2vw,3rem)]">Riwayat Pekerjaan</h1>
    <div class="w-full mt-1 h-2 bg-[#DDFFAC] mb-4"></div>
    <div class="overflow-x-auto rounded shadow border border-gray-200">
        <table class="min-w-full border-collapse">
            <thead class="bg-[#0E5509] text-white">
                <tr>
                    @php
                        $dataUser = session('dataUser');
                    @endphp
                    @if ($dataUser['status'] == "Kepala Dinas")
                        <th class="px-4 py-2 whitespace-nowrap">Nama Staf</th>
                    @endif
                    <th class="px-4 py-2 whitespace-nowrap">Nama Petani</th>
                    <th class="px-4 py-2 whitespace-nowrap">Alamat</th>
                    <th class="px-4 py-2 whitespace-nowrap">Nama Tanaman</th>
                    <th class="px-4 py-2 whitespace-nowrap">Jenis Lahan</th>
                    <th class="px-4 py-2 whitespace-nowrap">Status Tanam</th>
                    <th class="px-4 py-2 whitespace-nowrap">Tanggal Laporan</th>
                    <th class="px-4 py-2 whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('report') as $index => $item)
                    <tr class="{{ $index % 2 == 0 ? 'bg-[#DDFFAC]' : '' }} hover:bg-[#c6ef9d]">
                        @if ($dataUser['status'] == "Kepala Dinas")
                            <td class="px-4 py-2 whitespace-nowrap">{{ $item['namaStaf'] }}</td>
                        @endif
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['namaPetani'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['alamat'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['nama_tanaman'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['jenis_lahan'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['status_tanam'] }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $item['waktu_laporan'] }}</td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('gotoMapping') }}" method="GET">
                                <input type="hidden" name="lat" value="{{ $item['lat'] }}">
                                <input type="hidden" name="lng" value="{{ $item['lng'] }}">
                                <button type="submit" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-800">
                                    Detail
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
