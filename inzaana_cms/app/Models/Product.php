<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected table = 'products';
	 
	public function user()
    {
        return $this->belongsTo('App\User');
    }
	public function sendApprovals()
	{
		return $this->hasMany('App\SendApproval');
	}
}
