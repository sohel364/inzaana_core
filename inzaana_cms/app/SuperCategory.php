<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuperCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'super_categories';

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
