<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class HtmlViewContent extends Model
{
    //
    protected $table = 'html_view_contents';
    protected $guarded = [];

    /**
     * Get the html view menu associated with the content.
     */
    public function htmlViewMenu()
    {
        return $this->hasOne('Inzaana\HtmlViewMenu');
    }
}
