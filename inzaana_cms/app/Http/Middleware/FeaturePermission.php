<?php

namespace Inzaana\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class FeaturePermission
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
     * Check feature exist on plan
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->user() != null && $this->auth->user()->featureAccessPermission($request->path()))
        {
            return $next($request);
        }elseif($this->auth->user() != null && $this->auth->user()->id == 1){ // This line perform super admin request bypass
            return $next($request);
        }else{
            abort(403);
        }
    }
}
