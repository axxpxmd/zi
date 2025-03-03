<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengungkitIndikator1 extends Model
{
    protected $table = 'tm_pengungkit_indikator1';
    protected $guarded = [];

    public function pengungkitIndikator2()
    {
        return $this->hasMany(PengungkitIndikator2::class, 'pengungkit_indikator1_id', 'id');
    }
}
