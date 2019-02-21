<?php

namespace App\Http\Controllers;

use App\Tipotarjeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipostarjetasController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $tp = Tipotarjeta::all();
        return view('configuracion.tipotarjeta.index')
            ->with(compact('tp'));
    }

    public function store(Request $request)
    {
        $compa = Tipotarjeta::all()->where('codigo', $request->codigo);
        if ($compa != '[]')
        {
            return 'ya existe';
        }else{
            $tp = new Tipotarjeta;
            $tp->nombre = $request->nombre;
            $tp->codigo = $request->codigo;
            $tp->estado= $request->estado;
            $tp->user_id= Auth::id();
            $tp->save();
            return 'guardado';
        }
    }

    public function datostabla()
    {
        $id = Auth::id();
        $tp = Tipotarjeta::all();
        if ($tp == '[]'){
            $tp = 'vacio';
        }
        return $tp;
    }
    public  function edit(Request $request)
    {
        $tp = Tipotarjeta::find($request->id);
        $tp->nombre = $request->nombre;
        $tp->codigo = $request->codigo;
        $tp->estado = $request->estado;
        $tp->update();

        return 'editado';
    }
}
