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
    protected $fillable = [ 'name', 'user_id', 'name_as_url', 'sub_domain', 'domain', 'description' ]; 
    
    protected $guarded = [];

    public function user()
    {    	
        return $this->belongsTo('Inzaana\User');
    }

    public static function types()
    {
        return [
            'id' => [ 0, 1, 2, 3, 4 ],
            'title' => [ 
                'I\'m not sure yet.', 'Animal &amp; Pet', 'Art &amp; Entertainment', 'Hardware or Home/Garden Improvement', 'Others / something else...'
            ]
        ]; 
    }
}
