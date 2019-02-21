<?php

namespace App\Http\Controllers\Auth;

use App\Client_database;
use App\Clients_auth;
use App\Core\ClientDbSwitcher;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Authcontroller extends Controller
{
    public function loginview()
    {
        return view('auth.login');
    }
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required',
            'fingerprint' => 'string'
        ]);

        if ($validator->fails())
        {
            return Redirect::to('login')->withErrors($validator) // send back all errors to the login form
            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $clientdatabase = Client_database::where("auth_id", Auth::id())->first();
//            dd($clientdatabase);
            try{
                ClientDbSwitcher::switchToDb(
                    $clientdatabase
                );

            }catch (\Exception $e){
                return ' error';
            }

            return Redirect::to('/');
        }

    }

    protected function respondWithTokenAndUser()
    {

    }
}
