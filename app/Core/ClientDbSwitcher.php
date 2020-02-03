<?php

namespace App\Core;

use App\Caja;
use App\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClientDbSwitcher
{
    public static function switchToClientDb ($client_id){

    }

    public static function switchToDb($connection_data) {
        self::replaceDbConfig($connection_data);
        DB::purge('client');
    }

    public static function replaceDbConfig($connection_data){

        Config::set("database.connections.client", [
            "database" => $connection_data['name'],
            "driver"=> 'mysql',
//            "host"=> '127.0.0.1',
            'username'=> 'adgsoft',
//            'username'=> 'homestead',
            'password'=>'*1010537-130778442*',
            'password'=>'secret',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci'
        ]);
//        echo $connection_data;



    }

}