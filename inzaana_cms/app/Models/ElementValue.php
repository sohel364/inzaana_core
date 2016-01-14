<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementValue extends Model
{
     protected $table = 'element_values';

    public function element()
    {
        return $this->belongsTo('App\Element');
    }
}
