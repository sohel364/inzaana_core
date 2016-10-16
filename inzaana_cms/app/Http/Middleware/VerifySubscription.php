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
        if($this->auth->user()->featureAccessPermission($request->path()))
        {
            return $next($request);
        }else{
            abort(403);
        }
        /*throw new PaymentException($this->auth->user()->getPlanName());*/
    }
}
