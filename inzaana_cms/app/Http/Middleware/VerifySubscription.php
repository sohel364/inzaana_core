<?php

namespace Inzaana\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Inzaana\Payment\PaymentException;

class VerifySubscription
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next /*@param $stripe*/)
    {
        if($this->auth->user() != null && $this->auth->user()->userAccessPermission())
        {
            return $next($request);
        }elseif($this->auth->user() != null && $this->auth->user()->id == 1){ // This line perform super admin request bypass
            return $next($request);
        }else{
            return redirect('/subscribe');
        }
        /*throw new PaymentException($this->auth->user()->getPlanName());*/
    }
}
