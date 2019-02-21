<?php

namespace App\Http\Middleware;

use App\Client_database;
use App\Core\ClientDbSwitcher;
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

        $clientdatabase = Client_database::where("auth_id", Auth::id())->first();
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
