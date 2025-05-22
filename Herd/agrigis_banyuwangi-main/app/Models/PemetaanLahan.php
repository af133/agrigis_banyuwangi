<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemetaanLahan extends Model
{
    /** @use HasFactory<\Database\Factories\PemetaanLahanFactory> */
    use HasFactory;
    protected $table ='pemetaan_lahan';
    public $timestamps= false;
    protected $fillable=[
        'alamat','luas_lahan','status_tanam','id_titik_komoditas','id_poligon_komoditas','jenis_lahan_id','jenis_tanam_id','status_tanam','alamat'
    ];
    public function tanaman(){
        return $this->belongsTo(Tanaman::class,'jenis_tanam_id');
    }
    public function poligon(){
        return $this->belongsTo(PoligonKomoditas::class,'id_poligon_komoditas');
    }
    public function titik(){
        return $this->belongsTo(TitikKomoditas::class,'id_titik_komoditas');
    }
    
    public function lahan(){
        return $this->belongsTo(JenisLahan::class,'jenis_lahan_id');
    }
    public function laporanMapping(){
        return $this->hasMany(LaporanMapping::class,'pemetaan_lahan_id');
    }
}
