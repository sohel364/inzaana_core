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
    // protected $guarded = ['has_sub_category_id'];
	 
    public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }

    public function store()
    {
        return $this->belongsTo('Inzaana\Store');
    }

    public function marketproduct()
    {
        return $this->hasOne('Inzaana\MarketProduct');
    }

    /**
     * Get all of the products' product medias.
     */
    public function medias()
    {
        return $this->morphMany(Inzaana\ProductMedia::class, 'mediable');
    }

	public function sendApprovals()
	{
		return $this->hasMany('Inzaana\SendApproval');
	}

    public function approved()
    {
        return $this->status == 'APPROVED';
    }

    public function approve()
    {
        $this->status = 'APPROVED';
        $this->marketproduct->status = $this->status;
        return  $this->save() && $this->marketproduct->save();
    }
    
    /**
     * Calculates selling price
     */
    protected function saveDiscountedPrice()
    {
        $this->mrp = $this->marketproduct->price * ( 1 -  ( $this->discount / 100.0) );
        return $this->save();
    }

    public function getStatus()
    {
        switch($this->status)
        {
            case 'OUT_OF_STOCK':    return 'Out of stock';
            case 'ON_APPROVAL':     return 'On Apprval';
            case 'APPROVED':        return 'Approved';
            case 'REJECTED':        return 'Rejected';
        }
        return 'Unknown';
    }
}
