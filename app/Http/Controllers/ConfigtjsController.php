<?php

namespace App\Http\Controllers;

use App\Configtj;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigtjsController extends Controller
{

    public function store(Request $request)
    {
        $config = $request->config;
        $configtj = new Configtj;
        $configtj->config = json_encode($config);
        $configtj->tarjeta_id = $request->id;
        $configtj->user_id = Auth::id();
        $configtj->save();
        return 'Guardado';
    }
    public function buscartj(Request $request)
    {
       $datos = Configtj::all()->where('user_id', Auth::id())->where('tarjeta_id',$request->id);
       if ($datos == '[]'){
           $lista = 'vacio';
       }else{
           foreach ($datos as $lista){
               $lista = $lista;
           }
       }
       return $lista;
    }
    public function edit(Request $request)
    {
        $configedit = $request->config;
        $config = Configtj::find($request->id);
        $config->config = json_encode($configedit);
        $config->update();
        return 'editado';
    }

}
