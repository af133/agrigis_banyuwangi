<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TitikKomoditas extends Model
{
    
    public $timestamps = false;
    protected $table='titik_komoditas';
    protected $fillable =['lat','lng'];
    public function pengelolaan_lahan(){
        
        return $this->hasMany(PemetaanLahan::class, 'id_titik_komoditas');
    }
}
