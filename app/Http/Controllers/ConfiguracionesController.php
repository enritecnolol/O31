<?php

namespace App\Http\Controllers;

use App\Configuracion;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfiguracionesController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $config = Configuracion::all()->where('user_id', '==', $id);
        if ($config == '[]'){
            $confi = 'no';
        }else{
            foreach ($config as $confi){
                $confi = $confi;
            }
        }
        return view('configuracion.index',['config' => json_encode($confi)]);
    }
    public function store(Request $request)
    {
        $configuracion = new Configuracion();
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $configuracion->nombreempresa = $request->nombreempresa;
            $configuracion->telefono = $request->telefono;
            $configuracion->ciudad = $request->ciudad;
            $configuracion->pais = $request->pais;
            $configuracion->direccion = $request->direccion;
            $configuracion->img = $file->getClientOriginalName();
            $configuracion->impuesto = $request->impuesto;
            $configuracion->descuento = $request->descuento;
            $configuracion->controlinv = $request->inventario;
            $configuracion->user_id = Auth::id();
            $configuracion->save();


        }else{

            $configuracion->nombreempresa = $request->nombreempresa;
            $configuracion->telefono = $request->telefono;
            $configuracion->ciudad = $request->ciudad;
            $configuracion->pais = $request->pais;
            $configuracion->direccion = $request->direccion;
            $configuracion->img = 'default.jpg';
            $configuracion->impuesto = $request->impuesto;
            $configuracion->descuento = $request->descuento;
            $configuracion->controlinv = $request->inventario;
            $configuracion->user_id = Auth::id();
            $configuracion->save();
        }
        return redirect('/configuracion');

    }
    public function update(Request $request)
    {
        $id = $request->id;
        $configuracion = Configuracion::find($id);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $configuracion->nombreempresa = $request->nombreempresa;
            $configuracion->telefono = $request->telefono;
            $configuracion->ciudad = $request->ciudad;
            $configuracion->pais = $request->pais;
            $configuracion->direccion = $request->direccion;
            $configuracion->img = $file->getClientOriginalName();
            $configuracion->impuesto = $request->impuesto;
            $configuracion->descuento = $request->descuento;
            $configuracion->controlinv = $request->inventario;
            $configuracion->update();

        }else{
            $configuracion->nombreempresa = $request->nombreempresa;
            $configuracion->telefono = $request->telefono;
            $configuracion->ciudad = $request->ciudad;
            $configuracion->pais = $request->pais;
            $configuracion->direccion = $request->direccion;
            $configuracion->impuesto = $request->impuesto;
            $configuracion->descuento = $request->descuento;
            $configuracion->controlinv = $request->inventario;
            $configuracion->update();
        }

        return redirect('/configuracion');
    }

    public function clientepreferencialindex()
    {
        return view('configuracion.clientepreferencial.index');
    }

    public function existencia()
    {
        $existencias = Configuracion::all()->where('user_id', Auth::id());
        foreach($existencias as $existencia)
        {
            $existencia = $existencia->controlinv;
        }
        return $existencia;
    }
    public function manejoitbis()
    {
        $config = DB::table('configuracions')->select('impuesto')->where('user_id', Auth::id())->get();

        if ($config == '[]'){
            $config = 'vacio';
        }elseif($config == '[{"impuesto":"incluido"}]'){
            $config = 'incluido';
        }elseif ($config == '[{"impuesto":"sumado"}]'){
            $config = 'sumado';
        }
        return $config;
    }
}
