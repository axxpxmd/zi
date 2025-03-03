<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'tm_unit_kerja';
    protected $fillable = ['id', 'alamat', 'n_unit_kerja', 'status', 'created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'unit_kerja_id', 'id');
    }
}
