<?php

namespace App\Models;

use App\TmResult;
use Illuminate\Database\Eloquent\Model;

// Models
use App\User;

class Pegawai extends Model
{
    protected $table = 'tm_pegawais';
    protected $fillable = [
        'id',
        'user_id',
        'unit_kerja_id',
        'nama_instansi',
        'nama_kepala',
        'jabatan_kepala',
        'nama_operator',
        'jabatan_operator',
        'email',
        'telp',
        'alamat',
        'foto',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }

    public static function queryData($role_id)
    {
        return Pegawai::select('tm_pegawais.id as id', 'user_id', 'nama_instansi', 'unit_kerja_id', 'nama_kepala', 'jabatan_kepala', 'nama_operator', 'jabatan_operator', 'email', 'telp')
            ->with(['user', 'unitKerja'])
            ->leftjoin('tm_unit_kerja', 'tm_unit_kerja.id', '=', 'tm_pegawais.unit_kerja_id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'tm_pegawais.user_id')
            ->when($role_id, function ($q) use ($role_id) {
                return $q->where('model_has_roles.role_id', $role_id);
            })
            ->orderBy('tm_pegawais.id', 'DESC')
            ->get();
    }
}
