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
        return collect([
            ['id' => 'NOT_SURE', 'title' => 'I\'m not sure yet.'],
            ['id' => 'ANIMAL_PET', 'title' => 'Animal &amp; Pet'],
            ['id' => 'ART_ENTERTAINMENT', 'title' => 'Art &amp; Entertainment'],
            ['id' => 'HARDWARE_HOME_DEVELOPMENT', 'title' => 'Hardware or Home/Garden Improvement'],
            ['id' => 'OTHERS', 'title' => 'Others / something else...'],
        ]);
    }

    public function getStatus()
    {
        switch($this->status)
        {
            case 'ON_APPROVAL':     return 'On Apprval';
            case 'APPROVED':        return 'Approved';
            case 'REJECTED':        return 'Rejected';
        }
        return 'Unknown';
    }
}
