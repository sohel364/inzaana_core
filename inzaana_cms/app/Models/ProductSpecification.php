<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
     protected table = 'product_specifications';
	 
	 public function user()
	 {
		return $this->belongsTo('App\User');
	 }
	 
}
