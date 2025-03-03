<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserUnitKerja extends Model
{
    protected $table = 'tr_user_unit_kerja';
    protected $guarded = [];

    public function unitKerja()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'unit_kerja_id');
    }
}
