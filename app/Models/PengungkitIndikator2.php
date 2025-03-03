<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengungkitIndikator2 extends Model
{
    protected $table = 'tm_pengungkit_indikator2';
    protected $guarded = [];

    public function pengungkitIndikator1()
    {
        return $this->belongsTo(PengungkitIndikator1::class, 'pengungkit_indikator1_id');
    }

    public function pengungkit_indikator3()
    {
        return $this->hasMany(PengungkitIndikator3::class, 'pengungkit_indikator2_id', 'id');
    }
}
