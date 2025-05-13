<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    /** @use HasFactory<\Database\Factories\TanamanFactory> */
    use HasFactory;
    public $timestamps = false;
    protected $table='tanaman';
    protected $fillable =['nama_tanaman'];
    public function pengelolaan_lahan(){
        return $this->hasMany('jenis_tanam_id');
    }
}
