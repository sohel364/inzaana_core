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
    protected $guarded = ['has_sub_category_id'];
	 
	public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }

	public function sendApprovals()
	{
		return $this->hasMany('Inzaana\SendApproval');
	}

    public function category()
    {
        return $this->belongsTo('Inzaana\Category', 'category_subcategory_id');
    }

    public function getStatus()
    {
        if($this->status == 'OUT_OF_STOCK')
        {
            return 'Out of stock';
        }
        return 'Unknown';
    }
}
