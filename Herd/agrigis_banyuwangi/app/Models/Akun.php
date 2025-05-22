<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    /** @use HasFactory<\Database\Factories\AkunFactory> */
    use HasFactory;
    protected $table ='akun';
    public $timestamps = false;
    protected $fillable =[
        'nama','nmr_telpon','email','password','path_img','status_id',
    ];
    public function status(){
        return $this->belongsTo(StatusPekerjaan::class,'status_id');
    }
    public function laporanMapping(){
        return $this->hasMany(PemetaanLahan::class,'akun_id');
    }
}
