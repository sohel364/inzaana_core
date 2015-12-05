<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function superCategories()
    {
        $this->hasMany('App\SuperCategory');
    }
}
