<?php

namespace Inzaana;

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
        return $this->belongsTo('Inzaana\User');
    }

    public function superCategories()
    {
        return $this->hasMany('Inzaana\SuperCategory');
    }
}
