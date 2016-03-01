<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    //
    protected $table = 'templates';
    protected $guarded = [];

    public function user()
    {    	
        return $this->belongsTo('Inzaana\User');
    }

    /**
     * relationship with template and its view manus
     */
    public function htmlViewMenus()
    {
        return $this->hasMany('Inzaana\HtmlViewMenu');
    }

}
