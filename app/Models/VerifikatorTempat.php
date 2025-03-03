<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerifikatorTempat extends Model
{
    protected $table = 'tr_user_tempat';
    protected $fillable = ['id', 'user_id', 'tempat_id', 'tahun_id', 'created_at', 'updated_at'];

    public function tempat()
    {
        return $this->belongsTo(Tempat::class, 'tempat_id');
    }

    public function tahun()
    {
        return $this->belongsTo(Time::class, 'tahun_id');
    }
}
