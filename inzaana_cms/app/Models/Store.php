<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'name_as_url', 'sub_domain', 'domain'];
}
