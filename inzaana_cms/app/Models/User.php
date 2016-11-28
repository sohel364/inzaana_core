<?php

namespace Inzaana;
use Laravel\Cashier\Billable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Inzaana\Payment\CheckSubscription;
use Inzaana\Payment\StripePayment as StripePayment;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract,
                                    StripePayment
{
    use Authenticatable, Authorizable, CanResetPassword, Billable, CheckSubscription;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $dates = ['trial_ends_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'trial_ends_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->token = str_random(30);
        });
    }
    
    /**
     * Confirm the user.
     *
     * @return bool
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;

        return $this->save();
    }

    /**
     * Remove the user and confirms.
     *
     * @return bool
     */
    public function remove()
    {
        return $this->delete();
    }

    /**
     *
     */
    public function categories()
    {
        return $this->hasMany('Inzaana\Category');
    }

    /**
     *
     */
    public function products()
    {
        return $this->hasMany('Inzaana\Product');
    }

    /**
     *
     */
    public function templates()
    {        
        return $this->hasMany('Inzaana\Template');
    }

    /**
     *
     */
    public function stores()
    {        
        return $this->hasMany('Inzaana\Store');
    }

    public static function decodePhoneNumber($phone_number)
    {
        $codes = [ '+088', '+465', '+695' ];
        $keywords = preg_split("/[-]+/", $phone_number);
        if(count($keywords) == 1)
        {
            return [ 0, $keywords[0]];
        }
        $phone_number = $keywords[1];
        foreach($codes as $key => $value)
        {
            if($value == $keywords[0])
            {
                return [ $key, $phone_number ];
            }
        }
        return [0, ''];
    }

    public static function decodeAddress($address)
    {        
        $keywords = preg_split("/<address>/", $address);
        if(count($keywords) == 1)
            return [ 'DEFAULT' => '', 'HOUSE' => '', 'STREET' => '', 'LANDMARK' => '', 'TOWN' => '', 'POSTCODE' => '', 'STATE' => '' ];
        $addressDecoded = array();
        $sections = [ 'DEFAULT', 'HOUSE', 'STREET', 'LANDMARK', 'TOWN', 'POSTCODE', 'STATE' ];
        $index = 0;
        foreach($keywords as $keyword)
        {
            $addressDecoded[$sections[$index]] = $keyword;
            ++$index;
        }
        return $addressDecoded;
    }

    public static function encodeAddress(array $inputs)
    {
        $delimiter_address = "<address>";
        $address = $inputs['mailing-address'] . $delimiter_address;
        $address .= $inputs['address_flat_house_floor_building'] . $delimiter_address;
        $address .= $inputs['address_colony_street_locality'] . $delimiter_address;
        $address .= $inputs['address_landmark'] . $delimiter_address;
        $address .= $inputs['address_town_city'] . $delimiter_address;
        $address .= $inputs['postcode'] . $delimiter_address;
        $address .= $inputs['state'];

        return $address;
    }

    public static function postcodes($country)
    {
        $parser = \KzykHys\CsvParser\CsvParser::fromFile(str_replace('\\', '\\\\', storage_path('app/csv/india_contacts_db.csv')));
        $postcodes = array();
        if($country == 'INDIA')
        {
            foreach ($parser as $record) {
                $postcodes []= $record[3];
            }
        }
        return collect($postcodes)->unique()->forget(0);
    }

    public static function states($country)
    {
        $parser = \KzykHys\CsvParser\CsvParser::fromFile(str_replace('\\', '\\\\', storage_path('app/csv/india_contacts_db.csv')));
        $states = array();
        if($country == 'INDIA')
        {
            foreach ($parser as $record) {
                $states []= $record[0];
            }
        }
        return collect($states)->unique()->forget(0);
    }
}
