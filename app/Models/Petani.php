<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    /** @use HasFactory<\Database\Factories\PetaniFactory> */
    use HasFactory;
    protected $table='petani';
    public $timestamps=false;
    protected $fillable=[
        'nama','nmr_telpon','nik'
    ];
    
    public function laporanMapping(){
        return $this->hasMany(LaporanMapping::class,'petani_id');
    }
}
