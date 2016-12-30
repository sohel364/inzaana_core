<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['mrp', 'status'];

    const STATUS_FLOWS = [
        'ON_APPROVAL', 'UPLOAD_FAILED', 'APPROVED', 'REJECTED', 'OUT_OF_STOCK', 'AVAILABLE', 'NOT_AVAILABLE', 'ON_SHIPPING', 'REMOVED', 'COMING_SOON', 'SOLD', 'ORDERED'
    ];

    const VIEW_TYPES = [ 
        'group' => [ 'dropdown', 'checkboxes', 'options', 'scroller_vert', 'scroller_horiz' ],
        'single' => [ 'checkbox', 'label' ]
    ];
	 
    public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }

    public function store()
    {
        return $this->belongsTo('Inzaana\Store');
    }

    /**
     * Get all of the products' product medias.
     */
    public function medias()
    {
        return $this->morphMany(ProductMedia::class, 'mediable');
    }

    public function marketProduct()
    {
        return MarketProduct::find($this->market_product_id);
    }

    public function publicMarketProduct()
    {
        return $this->is_public ? $this->marketProduct() : null;
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
        if($this->marketProduct())
        {
            $this->marketProduct()->status = $this->status;
            $this->marketProduct()->save();
        }
        return $this->save();
    }
    
    /**
     * Saves discount calculated MRP
     */
    public function saveDiscountedPrice()
    {
        $this->mrp = $this->discountedPrice();
        return $this->save();
    } 
    
    /**
     * Calculates discounted MRP
     */
    public function discountedPrice()
    {
        return $this->marketProduct()->price * ( 1 -  ( $this->discount / 100.0) );
    } 

    public function isViewDropdown()
    {
        return ($this->special_specs->view_type == 'dropdown');
    }

    public function isViewOptions()
    {
        return ($this->special_specs->view_type == 'options');
    }

    public function isViewTypeGroup()
    {
        return array_has(array_flatten(ScanRule::VIEW_TYPES['group']), $this->special_specs->view_type);
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
