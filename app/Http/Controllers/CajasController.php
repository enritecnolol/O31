<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Facture;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\String_;

class   CajasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha = Caja::all()->where('fecha_apertura', '==', date("Y-m-d"))->last();

        if ($fecha == '[]'){
            $cerrad = 'no tiene';
        }else{
            $cerrad = $fecha["status"];
            $cuadre = $fecha["cuadreconf"];

        }
        return view('caja.iniciocaja', compact('fecha', $fecha), compact('cerrad', $cerrad))->with(compact('cuadre', $cuadre));
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
        $cajaapertura->cuadre = 'JSON';
        $cajaapertura->cuadreconf = 'No';
        $cajaapertura->user_id = Auth::id();
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
        $caja = DB::table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num')->where('fecha_apertura', date("Y-m-d"))->latest()->take(1)->get();
        $idcaja = $caja[0]->id;

        $ventas = Facture::all()->where('date','==',date("Y-m-d"))->where('caja_id', $idcaja)->count();

        $totalcierre = DB::table('factures')->select(DB::raw('SUM(total_facture) as total'))->where("date",$fecha)->where('caja_id', $idcaja)->get();

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

        return view('caja.cierrecaja', compact('ventas', $ventas), compact('caja', $caja))->with(compact('total', $total))->with(compact('valor_apertura', $valor_apertura));


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
    public function cuadrecaja(){
        $fecha = date('Y-m-d');
        $caja = DB::table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num', 'cuadreconf')->where('fecha_apertura', date("Y-m-d"))->where('status', 'C')->latest()->take(1)->get();
        $idcaja = $caja[0]->id;
        $ventastotal = DB::table('factures')->select(DB::raw('SUM(total_facture) as total'))->where("date",$fecha)->get();
        $ventasmonto_tarjeta = DB::table('factures')->select(DB::raw('SUM(Monto_tarjeta) as total_tarjeta'))->where('caja_id', $idcaja)->where("date",$fecha)->get();
        $ventasmonto_efectivo = DB::table('factures')->select(DB::raw('SUM(Monto_efectivo) as total_efectivo'))->where('caja_id', $idcaja)->where("date",$fecha)->get();
//        $caja = Caja::all()->where('fecha_apertura', '==', date("Y-m-d"))->where('status', '==', 'C');


        if ($ventastotal == '[{"total":null}]'){
            $total = 00;
        }else{
            $total = $ventastotal[0]->total;
        }

        if ($ventasmonto_tarjeta == '[{"total_tarjeta":null}]'){
            $total_tarjeta = 00;
        }else{
            $total_tarjeta = $ventasmonto_tarjeta[0]->total_tarjeta;
        }

        if ($ventasmonto_efectivo == '[{"total_efectivo":null}]'){
            $total_efectivo = 00;
        }else{
            $total_efectivo = $ventasmonto_efectivo[0]->total_efectivo;
        }

        if ($caja == '[]') {
            $nose = 'Abierta';
            $caja = $caja;
        }elseif ($caja[0]->cuadreconf == 'No'){
            $nose = 'NoCuadrada';
        }
        else{
            $caja = $caja;
            $nose = 'cuadrada';
        }

//            return $caja;
        return view('caja.cuadrecaja',
            compact('total'),
            compact('total_tarjeta'))
            ->with(compact('total_efectivo'))
            ->with(compact('fecha'))
            ->with(compact('caja'))
            ->with(compact('cerrada'))->with(compact('nose'));

    }

    public function cuadrarcj()
    {
        $data = Input::all();
        $cuadre = $data["encaja"];
        $id = $data["caja"][0]["id"];


        $caja = Caja::where('id', $id)->first();
        $caja->cuadre = json_encode($cuadre);
        $caja->cuadreconf = 'Si';
        $caja->update();

        return 'actulizado';
    }

}
