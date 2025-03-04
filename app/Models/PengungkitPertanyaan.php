<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengungkitPertanyaan extends Model
{
    protected $table = 'tm_pengungkit_pertanyaan';
    protected $guarded = [];

    public function pengungkitIndikator3()
    {
        return $this->belongsTo(PengungkitIndikator3::class, 'pengungkit_indikator3_id');
    }
}
