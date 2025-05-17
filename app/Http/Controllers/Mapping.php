<?php

namespace App\Http\Controllers;

use App\Models\LaporanMapping;

use App\Models\PemetaanLahan;
use App\Models\Tanaman;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Mapping extends Controller
{
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




    // --------------------------------------------------------------
    // -----------------------  Show Mapping  -----------------------
    // --------------------------------------------------------------
public function showMapping()
{
    $dataUser = session('dataUser');
    $akunId = $dataUser['id'];

    // Ambil ID laporan terbaru per titik koordinat
    $latestIds = LaporanMapping::select(DB::raw('MAX(laporan_mapping.id) as id'))
        ->join('pemetaan_lahan', 'laporan_mapping.pemetaan_lahan_id', '=', 'pemetaan_lahan.id')
        ->groupBy('pemetaan_lahan.lat', 'pemetaan_lahan.lng')
        ->pluck('id');

    $mapping = LaporanMapping::with([
            'akun',
            'petani',
            'pemetaanLahan',
            'pemetaanLahan.lahan',
            'pemetaanLahan.tanaman'
        ])
        ->whereIn('id', $latestIds)
        ->get();

    $result = [];
    $unreadCount = 0;

    foreach ($mapping as $item) {
        $result[] = $this->arrayMapping(
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

        // Cek apakah laporan ini belum dibaca
        if ($item->is_read == false) {
            $unreadCount++;
        }
    }

    // Simpan jumlah notifikasi yang belum dibaca ke session
    session(['notification_count' => $unreadCount]);

    return response()->json([
        'data' => $result,
        'unread_count' => $unreadCount
    ]);
}


    // --------------------------------------------------------------
    // -----------------------  Add Mapping  ------------------------
    // --------------------------------------------------------------

    public function addaMapping(Request $request){
        $validated = $request->validate([
            'namaPetani' => 'required|string',
            'alamat' => 'required|string',
            'luasLahan' => 'required|numeric',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'statusLahan' => 'required|string',
            'namaTanaman' => 'required|string',
            'statusPanen' => 'required|string',
            'nmr_telpon' => 'required|string',
            'nik' => 'required|string',
        ]);

        $petani = Petani::firstOrCreate(
            ['nik' => $validated['nik']],
            ['nmr_telpon' => $validated['nmr_telpon'], 'nama' => $validated['namaPetani']], //
        );
        $tanaman = Tanaman::firstOrCreate(
            ['nama_tanaman' => $validated['namaTanaman']]
    );

        $pemetaanLahan = PemetaanLahan::create([
            'alamat' => $validated['alamat'],
            'luas_lahan' => $validated['luasLahan'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'jenis_lahan_id' => $validated['statusLahan'],
            'jenis_tanam_id' => $tanaman->id,
            'status_tanam' => $validated['statusPanen'],
        ]);

        // Tambah laporan
        LaporanMapping::create([

            'akun_id' => session('dataUser')['id'],
            'petani_id' => $petani->id,
            'pemetaan_lahan_id' => $pemetaanLahan->id,
            'waktu_laporan' => now(),
        ]);
        return redirect()->route('mapping');

    }

}
