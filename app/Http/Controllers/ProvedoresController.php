<?php

namespace App\Http\Controllers;

use App\Entradacomprobantes;
use App\Provedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvedoresController extends Controller
{
    public function index()
    {
        return view('provedores.index');
    }
    public function store(Request $request)
    {
        $provedor = new Provedor();
        $provedor->nombre = $request->nombre;
        $provedor->razon_social= $request->razons;
        $provedor->direccion= $request->direccion;
        $provedor->pais= $request->pais;
        $provedor->provincia= $request->provincia;
        $provedor->ciudad= $request->ciudad;
        $provedor->sector= $request->sector;
        $provedor->telefono= $request->telefono;
        $provedor->email= $request->email;
        $provedor->contacto= $request->contacto;
        $provedor->itbis= $request->itbis;
        $provedor->tcontribuyente= $request->tipocontribuyente;
        $provedor->referencia= $request->referencia;
        $provedor->cedula= $request->cedula;
        $provedor->vendedor= $request->vendedor;
        $provedor->Condiciones= $request->condiciones;
        $provedor->tcxp_id= $request->tipocxp;
        $provedor->user_id= Auth::id();
        $provedor->save();

        return 'guardado';
    }
    public function todosdatos(Request $request)
    {
        if ($request->search){
            $provedores = Provedor::where('nombre', 'like', '%'.$request->search.'%')->paginate(5);
            return $provedores;
        }

        $provedores = Provedor::paginate(5);
        return $provedores;
    }
    public function edit(Request $request)
    {
        $provedor = Provedor::find($request->id);
        $provedor->nombre = $request->nombre;
        $provedor->razon_social= $request->razons;
        $provedor->direccion= $request->direccion;
        $provedor->pais= $request->pais;
        $provedor->provincia= $request->provincia;
        $provedor->ciudad= $request->ciudad;
        $provedor->sector= $request->sector;
        $provedor->telefono= $request->telefono;
        $provedor->email= $request->email;
        $provedor->contacto= $request->contacto;
        $provedor->itbis= $request->itbis;
        $provedor->tcontribuyente= $request->tipocontribuyente;
        $provedor->referencia= $request->referencia;
        $provedor->cedula= $request->cedula;
        $provedor->vendedor= $request->vendedor;
        $provedor->Condiciones= $request->condiciones;
        $provedor->tcxp_id= $request->tipocxp;
        $provedor->update();
        return 'Editar';
    }
    public function todosprovedores()
    {
        $provedores = Provedor::all()->where("user_id", Auth::id());
        return $provedores;
    }
}
