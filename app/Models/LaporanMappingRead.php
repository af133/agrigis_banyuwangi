<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMappingRead extends Model
{
    use HasFactory;

    protected $table = 'laporan_mapping_read';

    protected $fillable = [
        'laporan_mapping_id',
        'akun_id',
        'is_read',
    ];

    public function laporanMapping()
    {
        return $this->belongsTo(LaporanMapping::class, 'laporan_mapping_id');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'akun_id');
    }
}
