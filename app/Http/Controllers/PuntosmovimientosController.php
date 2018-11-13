<?php

namespace App\Http\Controllers;

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
}
