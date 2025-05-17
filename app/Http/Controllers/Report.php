<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanMapping;
class Report extends Controller
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
            'status_tanam' => $statusTanam
        ];
    }
public function showReport()
{
    $dataUser = session('dataUser');

    $mappingQuery = LaporanMapping::with([
        'akun',
        'petani',
        'pemetaanLahan',
        'pemetaanLahan.lahan',
        'pemetaanLahan.tanaman'
    ]);

    // Ambil data berdasarkan status user
    if ($dataUser['status'] == "Kepala Dinas") {
        $mappings = $mappingQuery->get();
    } else {
        $akunId = $dataUser['id'];
        $mappings = $mappingQuery->where('akun_id', $akunId)->get();
    }

    $report = [];

    foreach ($mappings as $item) {
        $report[] = $this->arrayMapping(
            $item->akun->nama ?? '-',
            $item->petani->nama ?? '-',
            $item->petani->nik ?? '-',
            $item->petani->nmr_telpon ?? '-',
            $item->pemetaanLahan->alamat ?? '-',
            $item->pemetaanLahan->luas_lahan ?? 0,
            $item->pemetaanLahan->lat ?? 0,
            $item->pemetaanLahan->lng ?? 0,
            $item->pemetaanLahan->lahan->jenis_lahan ?? '-',
            $item->pemetaanLahan->tanaman->nama_tanaman ?? '-',
            $item->waktu_laporan ?? '-',
            $item->pemetaanLahan->status_tanam ?? '-'
        );
    }

    // Hitung laporan yang belum dibaca
    $unreadCount = $mappings->where('is_read', false)->count();
    session(['notification_count' => $unreadCount]);


    session(['report' => $report]);

    return view('report.report');
}



}
