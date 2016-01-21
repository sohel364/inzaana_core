<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
     protected table = 'sub_categories';
	 
	 public function Category()
    {
        return $this->belongsTo('Inzaana\Category');
    }
}
