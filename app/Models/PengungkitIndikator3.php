<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengungkitIndikator3 extends Model
{
    protected $table = 'tm_pengungkit_indikator3';
    protected $guarded = [];

    public function pengungkitIndikator2()
    {
        return $this->belongsTo(PengungkitIndikator2::class, 'pengungkit_indikator2_id');
    }
}
