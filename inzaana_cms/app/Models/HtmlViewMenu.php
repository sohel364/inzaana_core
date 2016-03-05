<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class HtmlViewMenu extends Model
{
    //
    protected $table = 'html_view_menus';
    protected $guarded = [];

    public function template()
    {    	
        return $this->belongsTo('Inzaana\Template');
    }

    /**
     * Get the content associated with the html view menu.
     */
    public function content()
    {
        return $this->hasOne('Inzaana\HtmlViewContent');
    }
}
