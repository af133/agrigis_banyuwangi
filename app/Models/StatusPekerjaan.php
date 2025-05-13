<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\StatusPekerjaanFactory> */
    use HasFactory;
    protected $table='status_pekerja';
    public $timestamps = false;
    protected $fillable =['status'];
    public function akun()
    {
        return $this->hasMany(Akun::class, 'status_id');
    }
}
