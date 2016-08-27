<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    //
    protected $table = 'stores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id', 'name_as_url', 'sub_domain', 'domain']; 
    
    protected $guarded = [];   

    public function user()
    {    	
        return $this->belongsTo('Inzaana\User');
    }
}
