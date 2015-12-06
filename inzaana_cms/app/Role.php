<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';

    /*
     *
     */
    public function roleMenus()
    {
        return $this->hasMany('App\RoleMenu');
    }
}
