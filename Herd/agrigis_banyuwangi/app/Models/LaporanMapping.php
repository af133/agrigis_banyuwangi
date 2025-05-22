<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMapping extends Model
{
    /** @use HasFactory<\Database\Factories\LaporanMappingFactory> */
    use HasFactory;
    protected $table='laporan_mapping';
    protected $fillable =[
        'akun_id','pemetaan_lahan_id','petani_id','waktu_laporan'
    ];
    public $timestamps= false;
    public function akun(){
        return $this->belongsTo(Akun::class,'akun_id');
    }
    public function petani(){
        return $this->belongsTo(Petani::class,'petani_id');
    }
    public function pemetaanLahan(){
        return $this->belongsTo(PemetaanLahan::class,'pemetaan_lahan_id');
    }

}
