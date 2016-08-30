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
    public function handle($request, Closure $next, $stripe)
    {
        //dd(true);
        //dd($this->auth->user()->isAccess($stripe));
        /*if($this->auth->user()->isAccess($this->auth->user()->getPlanName()))
            return $next($request);

        throw new PaymentException($this->auth->user()->getPlanName());*/
    }
}
