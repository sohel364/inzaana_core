<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected table = 'products';
	 
	public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }
	public function sendApprovals()
	{
		return $this->hasMany('Inzaana\SendApproval');
	}
}
