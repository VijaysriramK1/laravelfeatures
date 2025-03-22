<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\RolePermission\Entities\SmaPermissionAssign;

class Role extends Model
{
    //
    public function permissions()
    {
        return $this->hasMany(SmaPermissionAssign::class, 'role_id', 'id');
    }
}
