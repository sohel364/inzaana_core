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
}
