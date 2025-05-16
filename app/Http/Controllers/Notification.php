<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMapping;
use App\Models\LaporanMappingRead;
class Notification extends Controller
{
    public function redirectToMapping(Request $request)
    {
    $lat = $request->query('lat');
    $lng = $request->query('lng');

    // Simpan ke session atau bisa langsung redirect
    return redirect()->route('mapping', ['lat' => $lat, 'lng' => $lng]);
    }
    public function index(Request $request)
    {
    $lat = $request->query('lat');
    $lng = $request->query('lng');
    return view('mapping.mapping', compact('lat', 'lng'));
    }

     // --------------------------------------------------------------
    // -----------------------  Array Mapping  ----------------------
    // --------------------------------------------------------------

    public function arrayMapping($namaStaf,$namaPetani,$nik,$telpon,$alamat, $luasLahan, $lat, $lng, $jenisLahan, $namaTanaman,$waktuLaporan,$statusTanam)
    {
        return [
            'namaStaf'=>$namaStaf,
            'namaPetani'=>$namaPetani,
            'nik'=>$nik,
            'telpon'=>$telpon,
            'alamat' => $alamat,
            'luas_lahan' => $luasLahan,
            'lat' => $lat,
            'lng' => $lng,
            'jenis_lahan' => $jenisLahan,
            'nama_tanaman' => $namaTanaman,
            'waktu_laporan' => $waktuLaporan,
            'status_tanam' => $statusTanam,
        ];
    }
public function showNotification()
{
    $userId = session('dataUser')['id'];

    // Ambil semua laporan yang belum dibaca
    $unreadLaporan = LaporanMapping::whereDoesntHave('readers', function ($query) use ($userId) {
        $query->where('akun_id', $userId);
    })->get();

    // Tandai semua sebagai sudah dibaca
    foreach ($unreadLaporan as $laporan) {
        LaporanMappingRead::create([
            'laporan_mapping_id' => $laporan->id,
            'akun_id' => $userId,
            'is_read' => true
        ]);
    }

    session(['notification_count' => 0]);

    return view('FolderNotifications.notifications');
;
}



}
