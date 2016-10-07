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
    protected $guarded = ['sup_category_id'];

    public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }

    public function superCategories()
    {
        return $this->hasMany('Inzaana\SuperCategory');
    }

    public function products()
    {
        return $this->hasMany('Inzaana\Product', 'category_subcategory_id');
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
