<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class SpecRule extends Model
{
    //
    protected $table = 'spec_rules';
    /**
     * Get all of the owning specificable models.
     */
    public function specificable()
    {
        return $this->morphTo();
    }
}
