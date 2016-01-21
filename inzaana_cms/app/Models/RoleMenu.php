<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    //
    protected $table = 'role_menus';

    /*
     *
     */
    public function role()
    {
        return $this->belongsTo('Inzaana\Role');
    }
}
