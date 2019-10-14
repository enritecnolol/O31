<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Configuracion;
use App\Detail;
use App\Facture;
use App\Orden;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
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
        $id = Auth::id();
        $fecha = Caja::all()->last();

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
        $id = Auth::id();
        $caja = DB::connection('client')->table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num', 'cuadreconf')->latest()->take(1)->get();
        if ($caja == '[]'){
            $idcaja = 0;
        }else{
            $idcaja = $caja[0]->id;

        }

        $ventas = Facture::where('caja_id', $idcaja)->count();

        $totalcierre = DB::connection('client')->table('factures')->select(DB::raw('SUM(total_facture) as total'))->where('caja_id', $idcaja)->get();

        if ($totalcierre == '[{"total":null}]'){
            $total = 0;
        }else{
            $total = $totalcierre[0]->total;
        }

        $apertura = DB::connection('client')->table('cajas')->select(DB::raw('valor_apertura'))->where("id",$idcaja)->get();

        if ($apertura == '[]'){
            $valor_apertura = 0;
        }else{
            $valor_apertura = $apertura[0]->valor_apertura;
        }

        $ordens = Orden::all()->where('estado', 'Abierta');
        if ($ordens == '[]'){
            $ordens = 0;
        }

        return view('caja.cierrecaja', compact('ventas', $ventas), compact('caja', $caja))->with(compact('total', $total))->with(compact('valor_apertura', $valor_apertura))->with(compact('ordens', $ordens));


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

        $configs = Configuracion::all();
        foreach ($configs as $config)
        {
            $email = $config->emailinfo;
        }

        $totaldias = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(total_facture) as total'))->where('date', $caja->fecha_apertura)->get();
        if ($totaldias == '[{"total":null}]'){
            $totaldias = number_format(0);
        }else{
            $totaldias = number_format($totaldias[0]->total);
        }
        $totalgasto = DB::connection('client')->table('entradacomprobantes')->select(DB::connection('client')->raw('SUM(netototal) as total'))->where('created_at', $caja->fecha_apertura)->get();
        if ($totalgasto == '[{"total":null}]'){
            $totalgasto = number_format(0);
        }else{
            $totalgasto = number_format($totalgasto[0]->total);
        }

        $totaldevolucion = DB::connection('client')->table('devolucions')->select(DB::connection('client')->raw('SUM(total_devolucion) as total'))->where('date', $caja->fecha_apertura)->get();
        if ($totaldevolucion == '[{"total":null}]'){
            $totaldevolucion = number_format(0);
        }else{
            $totaldevolucion = number_format($totaldevolucion[0]->total);
        }


        $ventasmes = DB::connection('client')->select("SELECT SUM(total_facture) as total FROM factures where month(date) = MONTH(CURDATE()) and year(date) = year(CURDATE())");
        if ($ventasmes == '[{"total":null}]'){
            $ventasmes = number_format(0);
        }else{
            $ventasmes = number_format($ventasmes[0]->total);
        }

        $data = array(
            'fecha'=> $caja->fecha_apertura,
            'totalvendido' => $totaldias,
            'totalgastos' => $totalgasto,
            'totaldevolucion' => $totaldevolucion,
            'totalmes' => $ventasmes,
            'compania' => $configs[0],
        );

        Mail::send('emails.resumendia', $data, function ($message) use ($email){
            $message->to($email)->subject(' CoffeBreakPOS | Resumen del Dia');
        });

        return 'Actualizado';

    }
    public function historico(){

        $fecha = date('Y-m-d');
        $total = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(total_facture) as total'))->where("date",$fecha)->get();
        if ($total == '[{"total":null}]'){
            $total = 0;
        }else{
            $total = $total[0]->total;
        }
        return view('caja.historicoventa', compact('total'));
    }
    public function cuadrecaja(){

//        $fecha = date('Y-m-d');
//        $id = Auth::id();
//        $caja = DB::table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num', 'cuadreconf')->where('fecha_apertura', date("Y-m-d"))->where('status', 'C')->where('user_id',$id)->latest()->take(1)->get();
//
//        if ($caja == '[]'){
//            $idcaja = 0;
//        }else{
//            $idcaja = $caja[0]->id;
//        }

//        $ventastotal = DB::table('factures')->select(DB::raw('SUM(total_facture) as total'))->where("date",$fecha)->where('caja_id', $idcaja)->get();
//        $ventasmonto_tarjeta = DB::table('factures')->select(DB::raw('SUM(Monto_tarjeta) as total_tarjeta'))->where('caja_id', $idcaja)->where("date",$fecha)->get();
//        $ventasmonto_efectivo = DB::table('factures')->select(DB::raw('SUM(Monto_efectivo) as total_efectivo'))->where('caja_id', $idcaja)->where("date",$fecha)->get();
//        $ventasmonto_devueltas = DB::table('factures')->select(DB::raw('SUM(returns) as total_devuelta'))->where('caja_id', $idcaja)->where("date",$fecha)->get();
//
//
//        if ($ventastotal == '[{"total":null}]'){
//            $total = 00;
//        }else{
//            $total = $ventastotal[0]->total;
//        }
//
//        if ($ventasmonto_tarjeta == '[{"total_tarjeta":null}]'){
//            $total_tarjeta = 00;
//        }else{
//            $total_tarjeta = $ventasmonto_tarjeta[0]->total_tarjeta;
//        }
//
//        if ($ventasmonto_efectivo == '[{"total_efectivo":null}]'){
//            $total_efectivo = 00;
//        }else{
//            $total_efectivo = $ventasmonto_efectivo[0]->total_efectivo - $ventasmonto_devueltas[0]->total_devuelta;
//        }
//
//        if ($caja == '[]') {
//
//            $nose = 'Abierta';
//            $caja = $caja;
//
//        }elseif ($caja[0]->cuadreconf == 'No'){
//            $nose = 'NoCuadrada';
//        }
//        else{
//            $caja = $caja;
//            $nose = 'cuadrada';
//        }
////        return $total_efectivo;
//
//        return view('caja.cuadrecaja',
//            compact('total'),
//            compact('total_tarjeta'))
//            ->with(compact('total_efectivo'))
//            ->with(compact('fecha'))
//            ->with(compact('caja'))
//            ->with(compact('cerrada'))->with(compact('nose'));

        $id = Auth::id();
        $cajas = DB::connection('client')->table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num', 'cuadreconf')->where('status', 'C')->where('cuadreconf','No')->get();
        return view('caja.cuadrecaja3', compact('cajas'));


    }
    public function infocaja(Request $request){

        $idcaja = $request->id;
        $id = Auth::id();
        $cajas = DB::connection('client')->table('cajas')->select('id','fecha_apertura','hora_apertura','fecha_cierre','almacen','valor_apertura','total_venta','total_cierre', 'usuario', 'status', 'caja_num', 'cuadreconf')->where('id',$idcaja)->get();

        $ventastotal = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(total_facture) as total'))->where('caja_id', $idcaja)->get();
        $ventasmonto_tarjeta = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(Monto_tarjeta) as total_tarjeta'))->where('caja_id', $idcaja)->get();
        $ventasmonto_efectivo = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(Monto_efectivo) as total_efectivo'))->where('caja_id', $idcaja)->get();
        $ventasmonto_devueltas = DB::connection('client')->table('factures')->select(DB::connection('client')->raw('SUM(returns) as total_devuelta'))->where('caja_id', $idcaja)->get();
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
            $total_efectivo = $ventasmonto_efectivo[0]->total_efectivo - $ventasmonto_devueltas[0]->total_devuelta;
        }


        return [$cajas, $total, $total_tarjeta, $total_efectivo];

    }

    public function cuadrarcj()
    {
        $data = Input::all();
        $cuadre = $data["encaja"];
        $id = $data["caja"]["id"];


        $caja = Caja::where('id', $id)->first();
        $caja->cuadre = json_encode($cuadre);
        $caja->cuadreconf = 'Si';
        $caja->update();

        return 'actualizado';
    }
    public function vercuadre(){
        return view('caja.vercuadres');

    }
    public function idcuadre($id){
        $caja = Caja::find($id);
        $json = json_decode($caja->cuadre, true);
        return view('caja.elcuadre', compact('caja'), compact('json'));

//        return $json;
    }


}
