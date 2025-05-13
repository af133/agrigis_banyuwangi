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
        'alamat','luas_lahan','lat','lng','jenis_lahan_id','jenis_tanam_id','status_tanam','alamat'
    ];
    public function tanaman(){
        return $this->belongsTo(Tanaman::class,'jenis_tanam_id');
    }
    public function lahan(){
        return $this->belongsTo(JenisLahan::class,'jenis_lahan_id');
    }
    public function laporanMapping(){
        return $this->hasMany(LaporanMapping::class,'pemetaan_lahan_id');
    }
}
