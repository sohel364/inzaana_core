<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class MarketProduct extends Model
{
    //
    protected $table = 'market_products';

    public function category()
    {
        return $this->belongsTo(Inzaana\Category::class);
    }

    /**
     * Get all of the Market Product's specrules.
     */
    public function specrules()
    {
        return $this->morphMany(Inzaana\SpecRule::class, 'specificable');
    }

    public function product()
    {
        return $this->hasOne('Inzaana\Product');
    }

    /**
     * Get all of the Market products' product medias.
     */
    public function medias()
    {
        return $this->morphMany(Inzaana\ProductMedia::class, 'mediable');
    }
}
