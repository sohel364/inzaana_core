<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;
use Faker\Factory as StoreFaker;

class Store extends Model
{
    //
    protected $table = 'stores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'user_id', 'name_as_url', 'sub_domain', 'domain', 'description', 'store_type' ]; 
    
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

    public function getStoreTypeIndex($id)
    {
        foreach ($this->types() as $key => $value)
        {
            if($value['id'] == $id)
            {
                return $key;
            }
        }
        return 0;
    }

    public function getStoreTypeAttribute()
    {
        foreach ($this->types() as $key => $value)
        {
            if($value['id'] == $this->attributes['store_type'])
            {
                return $value['title'];
            }
        }
        return 'Unknown';
    }

    /**
     * Suggest store names with given terms
     *
     * @param mixed
     * @param integer
     * @return array store names
     */
    public static function suggest($inputTerms, $limit)
    {
        $faker = StoreFaker::create();
        session([ 'input_terms' => $inputTerms ]); 
        $nameValidator = function($company) {
            return str_contains( strtolower((string) $company), strtolower(session('input_terms')) );
        };
        $companies = array();
        try
        {
            for ($i=0; $i < $limit; $i++)
                $companies []= $faker->valid($nameValidator)->company;

        } catch (\OverflowException $e) {
            
            session()->forget('input_terms');
            return "";
        }
        return $companies;
    }
}
