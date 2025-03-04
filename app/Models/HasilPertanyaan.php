<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPertanyaan extends Model
{
    protected $table = 'tm_hasil_pertanyaan';
    protected $guarded = [];

    public function hasilIndikator()
    {
        return $this->belongsTo(HasilIndikator::class, 'hasil_indikator_id');
    }
}
