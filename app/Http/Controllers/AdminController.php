<?php

namespace App\Http\Controllers;

use App\Client_database;
use App\Core\ClientDbSwitcher;
use App\User;
use Illuminate\Http\Request;
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
        $users = DB::select("SELECT users.id, users.name, users.email, client_databases.name as datab, client_databases.host, client_databases.port, client_databases.username, client_databases.password FROM users, client_databases WHERE users.id = client_databases.auth_id");
        $header = ['id', 'Nombre', 'Email', 'base de datos','Host', 'Port', 'Username', 'Password'];
        return ['header' => $header,'data' => $users];
    }
    public function store(Request $request)
    {
        User::create([
            'name' => $request->nameclient,
            'email' =>$request->email,
            'password' => bcrypt($request->pass),
        ]);

        $lastuser = User::all();

        $client_database = new Client_database();
        $client_database->auth_id = $lastuser->last()->id;
        $client_database->name = $request->database;
        $client_database->host = $request->host;
        $client_database->port = $request->port;
        $client_database->username = $request->username;
        $client_database->password = $request->password;
        $client_database->save();

        Artisan::call('mysql:createdb', [ 'name' => $request->database]);

        Config::set("database.connections.client", [
            "database" => $request->database,
            "driver"=> 'mysql',
            "host"=> 'localhost',
            'username'=> 'homestead',
            'password'=>'secret',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci'
        ]);

//        Artisan::call('migrate', [
//            '--force' => true,
//            '--database' => 'client',
//            '--path' => 'database/migrations',
//            '--seed' => true
//        ]);
//
//        DB::purge('auth');

        return 'save';
    }
    public function edit(Request $request)
    {
        $client_database = Client_database::where("auth_id", $request->item['id'])->first();
        $client_database->name = $request->item['datab'];
        $client_database->host = $request->item['host'];
        $client_database->port = $request->item['port'];
        $client_database->username = $request->item['username'];
        $client_database->password = $request->item['password'];
        $client_database->update();

        return 'edited';
    }
}
