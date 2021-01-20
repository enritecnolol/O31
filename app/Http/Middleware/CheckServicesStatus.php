<?php


namespace App\Http\Middleware;


use App\User;
use Illuminate\Support\Facades\Auth;

class CheckServicesStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {

        $user = User::find(Auth::id());

        if(!$user->status)
        {
            Auth::logout();
            return redirect('/account/deactivated');
        }

        return $next($request);
    }
}