<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'has_sub_category_id'];
	 
	public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }
	public function sendApprovals()
	{
		return $this->hasMany('Inzaana\SendApproval');
	}
}
