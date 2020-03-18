<?php

namespace App\Http\Controllers;

use App\User;
use App\UserClient;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterUsersController extends Controller
{

    public function index()
    {
        return view('register.user');
    }

    public function store(Request $request)
    {

        DB::connection('client')->begintransaction();

        if(User::where('email', $request['email'])->first() || UserClient::where('email', $request['email'])->first())
        {
            return response()->json(['message' => "Este Email ya esta en uso"], 400);
        }

        try{

            $user = UserClient::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);

            $user_connection = User::find(Auth::id());

            User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'client_databases_id' => $user_connection->client_databases_id
            ]);

            DB::connection('client')->commit();
            return $user;

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }

    }

    public function resetPassword(Request $request)
    {

        DB::connection('client')->begintransaction();

        try{

            $userClient = UserClient::find($request['user_id']);
            $userClient->password = bcrypt("123456789");
            $userClient->update();

            $user = User::where('email', $userClient->email)->first();

            $userAuth = User::find($user->id);
            $userAuth->password = bcrypt("123456789");
            $userAuth->update();

            DB::connection('client')->commit();
            return response()->json(['message' => "La Contraseña se ha reseteado con exito"], 200);

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }

    }

    public function userList()
    {
        $users = UserClient::all();
        return $users;
    }

    public function disableAccount(Request $request)
    {

        DB::connection('client')->begintransaction();
        try{

            $userClient = UserClient::find($request['user_id']);
            $userClient->status = false;
            $userClient->update();

            DB::connection('client')->commit();
            return response()->json(['message' => "El usuario que ha seleccionado ha sido deshabilitado"], 200);

        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }

    }
}
