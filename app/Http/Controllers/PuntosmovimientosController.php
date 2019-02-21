<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Puntosmovimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PuntosmovimientosController extends Controller
{
    public function buscadorticket(Request $request)
    {
        $tickets = DB::connection('client')->select("SELECT puntosmovimientos.*, clients.nombre FROM puntosmovimientos, clients WHERE puntosmovimientos.id = '".$request->id."' AND puntosmovimientos.cliente_id = clients.id AND puntosmovimientos.fecha between date_sub(now(),INTERVAL 1 WEEK) and now() ");
//        $tickets = Puntosmovimiento::all()->where('id', $request->id);
        if ($tickets == []){
            $tickets = 'no encontrado';
        }
        return $tickets;
    }
    public function tickets()
    {
        $iduser = Auth::id();
        $tickets = Puntosmovimiento::all()->where('fecha', date('Y-m-d'));
        if ($tickets == '[]'){
            $tickets = 'vacio';
        }
        return $tickets;
    }
    public function movimientocliente(Request $request)
    {
        $iduser = Auth::id();

        $tickets = DB::connection('client')->select("SELECT * FROM puntosmovimientos WHERE puntosmovimientos.fecha BETWEEN '".$request->inicio."' AND '".$request->fin."' AND puntosmovimientos.cliente_id = ".$request->id);
        $compania = Configuracion::all();

        if ($tickets == []){
            $tickets = 'vacio';
        }
        return [$tickets, $compania];
    }
}
