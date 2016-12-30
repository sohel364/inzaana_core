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

    const ROOT_ID = 0;

    public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }

    public function marketproducts()
    {
        return $this->hasOne('Inzaana\MarketProduct');
    }

    /**
     * Get all of the Market Product's specrules.
     */
    public function specrules()
    {
        return $this->morphMany(SpecRule::class, 'specificable');
    }

    public function subCategory()
    {
        return Category::whereParentCategoryId($this->id)->first();
    }

    public function hasSubCategory()
    {
        return Category::whereParentCategoryId($this->id)->count() > 0;
    }

    public function parent()
    {
        return ($this->parent_category_id == self::ROOT_ID) ? null : Category::find($this->parent_category_id);
    }

    public function isRoot()
    {
        return $this->parent_category_id == 0;
    }

    public function approved()
    {
        return $category->status == 'APPROVED';
    }

    public function approve()
    {
        $category->status = 'APPROVED';
        return $this->save();
    }

    public function approvable()
    {
        if($this->parent() && !$this->parent()->approved())
            return $this->parent()->approvable();
        return $this->approved();
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
