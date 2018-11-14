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
        $tickets = DB::select("SELECT puntosmovimientos.*, clients.nombre FROM puntosmovimientos, clients WHERE puntosmovimientos.id = '".$request->id."' AND puntosmovimientos.user_id = '".Auth::id()."' AND puntosmovimientos.cliente_id = clients.id AND puntosmovimientos.fecha between date_sub(now(),INTERVAL 1 WEEK) and now() ");
//        $tickets = Puntosmovimiento::all()->where('id', $request->id);
        if ($tickets == []){
            $tickets = 'no encontrado';
        }
        return $tickets;
    }
    public function tickets()
    {
        $iduser = Auth::id();
        $tickets = Puntosmovimiento::all()->where('user_id', $iduser)->where('fecha', date('Y-m-d'));
        return $tickets;
    }
    public function movimientocliente(Request $request)
    {
        $iduser = Auth::id();

        $tickets = DB::select("SELECT * FROM puntosmovimientos WHERE puntosmovimientos.fecha BETWEEN '".$request->inicio."' AND '".$request->fin."' AND puntosmovimientos.user_id = ".$iduser." AND puntosmovimientos.cliente_id = ".$request->id);
        $compania = Configuracion::all()->where('user_id',Auth::id());

        if ($tickets == []){
            $tickets = 'vacio';
        }
        return [$tickets, $compania];
    }
}
