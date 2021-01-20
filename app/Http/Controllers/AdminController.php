<?php

namespace App\Http\Controllers;

use App\Client_database;
use App\Core\ClientDbSwitcher;
use App\User;
use App\UserClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminlogin.index');
    }
    public function userlist()
    {
        $users = DB::select("SELECT users.id, users.name, users.email, client_databases.name as datab, users.amount, users.trial_period, users.start_trial, users.end_trial, users.status FROM users, client_databases WHERE users.id = client_databases.auth_id");
        $header = ['id', 'Nombre', 'Email', 'base de datos','Monto', 'Periodo prue.', 'Inicio', 'Fin', 'Estado'];
        return ['header' => $header,'data' => $users];
    }
    public function store(Request $request)
    {

        if(DB::table('users')->where('email', $request->email)->first())
        {
            return response()->json(['message' => "Ese Correo ya esta en uso"],400);
        }

        $client_database = new Client_database();
        $client_database->auth_id = 0;
        $client_database->name = $request->database;
        $client_database->host =  Config::get("database.connections.auth.host");
        $client_database->port =  Config::get("database.connections.auth.port");
        $client_database->username =  Config::get("database.connections.auth.username");
        $client_database->password =  Config::get("database.connections.auth.password");
        $client_database->save();

        $start_trial = date("Y-m-d h:i:s");
        $end_trial = date('Y-m-d h:i:s', strtotime($start_trial. " + $request->trial_period days"));

        User::create([
            'name' => $request->nameclient,
            'email' => $request->email,
            'password' => bcrypt($request->pass),
            'client_databases_id' => $client_database->id,
            'trial_period' => $request->trial_period,
            'start_trial' => $start_trial,
            'end_trial' => $end_trial,
            'amount' => $request->amount,
            'status' => 1
        ]);


        Artisan::call('mysql:createdb', [ 'name' => $request->database]);


        Config::set("database.connections.client", App::environment('local') ?
            [
                "database" => $request->database,
                "driver"=> 'mysql',
                "host"=> 'localhost',
                'username'=> 'root',
                'password'=>'secret',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci'
            ] : [
                "database" => $request->database,
                "driver"=> 'mysql',
                "host"=> '127.0.0.1',
                'username'=> 'adgsoft',
                'password'=>'*1010537-130778442*',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci'
            ] );

        Artisan::call('migrate', [
            '--force' => true,
            '--database' => 'client',
            '--path' => 'database/migrations',
            '--seed' => true
        ]);

        UserClient::create([
            'name' => $request->nameclient,
            'email' => $request->email,
            'password' => bcrypt($request->pass)
        ]);

        DB::purge('auth');

        return 'save';
    }

    public function edit(Request $request)
    {
        $start_trial = date("Y-m-d h:i:s");
        $trial = $request->item['trial_period'];
        $end_trial = date('Y-m-d h:i:s', strtotime($start_trial. " + $trial days"));

        $user = User::find($request->item['id']);
        $user->email = $request->item['email'];
        $user->amount = $request->item['amount'];
        if($user->trial_period != $trial)
        {
            $user->trial_period = $trial;
            $user->start_trial = $start_trial;
            $user->end_trial = $end_trial;
        }
        $user->status = $request->item['status'];
        $user->update();

        return 'edited';
    }
}
