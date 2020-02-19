<?php

namespace App\Http\Middleware;

use App\Client_database;
use App\Core\ClientDbSwitcher;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class set_databases
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::find(Auth::id());
        $clientdatabase = null;

        if(!is_null($user))
        {
            $clientdatabase = Client_database::find($user->client_databases_id);
        }

        try{
            ClientDbSwitcher::switchToDb(
                $clientdatabase
            );

        }catch (\Exception $e){
            return ' error';
        }
        return $next($request);
    }
}
