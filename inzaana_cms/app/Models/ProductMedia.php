<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    //
    protected $table = 'product_medias';

    /**
     * Get all of the owning mediable models.
     */
    public function mediable()
    {
        return $this->morphTo();
    }
}
