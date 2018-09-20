<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Facture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\String_;

class CajasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha = Caja::all()->where('fecha_apertura', '==', date("Y-m-d"));
        if ($fecha == '[]'){
            $cerrada = 'no tiene';
        }else{
            $cerrada = $fecha[0]["status"];
        }

        return view('caja.iniciocaja', compact('fecha'), compact('cerrada'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cajaapertura = new Caja;
        $cajaapertura->fecha_apertura = date("Y-m-d");
        $cajaapertura->hora_apertura = date('H:i:s');
        $cajaapertura->fecha_cierre = date("Y-m-d");
        $cajaapertura->almacen = 1;
        $cajaapertura->valor_apertura = $request->total;
        $cajaapertura->total_venta = 0;
        $cajaapertura->total_cierre = 0;
        $cajaapertura->usuario = 'general';
        $cajaapertura->status = 'A';
        $cajaapertura->caja_num = 1;
        $cajaapertura->save();
        return 'Guardado';
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cierrecaja(){

        $fecha = date('Y-m-d');
//
        $ventas = Facture::all()->where('date','==',date("Y-m-d"))->count();
        $totalcierre = DB::table('factures')->select(DB::raw('SUM(total_facture) as total'))->where("date",$fecha)->get();
        $caja = Caja::all()->where('fecha_apertura', '==', date("Y-m-d"));

        if ($totalcierre == '[{"total":null}]'){
            $total = 0;
        }else{
            $total = $totalcierre[0]->total;
        }

        $apertura = DB::table('cajas')->select(DB::raw('valor_apertura'))->where("fecha_apertura",$fecha)->get();

        if ($apertura == '[]'){
            $valor_apertura = 0;
        }else{
            $valor_apertura = $apertura[0]->valor_apertura;
        }
//

        return view('caja.cierrecaja', compact('ventas', $ventas), compact('caja', $caja))->with(compact('total', $total))->with(compact('valor_apertura', $valor_apertura));
//        return $totalcierre;

    }
    public function cerrarcaja(){


        $data = Input::all();
        $total_venta = $data["ventas"];
        $total_cierre = $data["total"];
        $valor_apertura = $data["valor_apertura"];
        $suma = $total_cierre + $valor_apertura;
        $id = $data["caja"][0]["id"];



        $caja = Caja::where('id', $id)->first();
        $caja->fecha_cierre = now();
        $caja->total_venta = $total_venta;
        $caja->total_cierre = $suma;
        $caja->status = 'C';
        $caja->update();


        return 'Actualizado';

    }
    public function historico(){
        return view('caja.historicoventa');
    }
}
