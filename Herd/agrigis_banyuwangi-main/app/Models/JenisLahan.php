<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLahan extends Model
{
    /** @use HasFactory<\Database\Factories\JenisLahanFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $table='jenis_lahan';
    protected $fillable =['jenis_lahan'];
    public function pengelolaan_lahan(){
        return $this->hasMany('jenis_lahan_id');
    }
}
