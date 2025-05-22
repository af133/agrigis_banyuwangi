<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoligonKomoditas extends Model
{
     public $timestamps = false;
    protected $table='poligon_komoditas';
    protected $fillable =['koordinat_poligon'];
    public function pengelolaan_lahan(){
        return $this->hasMany(PemetaanLahan::class, 'id_poligon_komoditas');
    }
}
