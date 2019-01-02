<?php

namespace App\Http\Controllers;

use App\Details_orden;
use App\Mesa_temp;
use App\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MesatempsController extends Controller
{
    public function store(Request $request)
    {
        $mesa = new Mesa_temp;
        $mesa->coroto_id = $request->id;
        $mesa->invitados = $request->personas;
        $mesa->save();
        return 'save';
    }
    public function all()
    {
        $mesas = DB::select("SELECT mesa_temps.*, corotos.name FROM mesa_temps, corotos WHERE mesa_temps.coroto_id = corotos.id");
        return $mesas;
    }
    public function ordenxmesa(Request $request)
    {
        $orden = Orden::all()->where('mesa_id', $request->id)->where('estado', 'Abierta');
        $details = Details_orden::all()->where('orden_id', $orden->last()->id);
        return ['orden' => $orden, 'detalle' => $details];
//        return $orden->last()->id;
    }
    public function productoselect(Request $resquest)
    {
        $id = Auth::id();
        $productos = DB::table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->where('products.user_id', $id)->where('products.id', $resquest->id)
            ->select(DB::raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();
        return $productos;
    }
}
