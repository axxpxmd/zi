<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model
use Spatie\Permission\Models\Role;

class ModelHasRole extends Model
{
    protected $table    = 'model_has_roles';
    protected $fillable = ['role_id', 'model_type', 'model_id', 'created_at', 'updated_at'];
    public $timestamps = false;
    protected $primaryKey = 'model_id';

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
