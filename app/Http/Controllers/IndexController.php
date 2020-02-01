<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Categoria;
use App\Client;
use App\Client_database;
use App\Configuracion;
use App\Core\ClientDbSwitcher;
use App\Detail;
use App\Detallesecuencia;
use App\Facture;
use App\Product;
use App\Puntosmovimiento;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\String_;


class IndexController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hora = date("h:m:i");

        $fecha_actual = strtotime(date("d-m-Y h:i:00",time()));
        $fecha_entrada = strtotime("9:00:00 PM");

        if($fecha_actual > $fecha_entrada)
        {
            $alerta = "si";
        }else
        {
            $alerta =  "no";
        }

        $id = Auth::id();
        $caja =  Caja::all()->last();
        $productos = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

        if ($caja == '[]' || $caja == null){
            $cerrada = 'C';
        }else{
            if($caja->fecha_apertura != date("Y-m-d") and $caja->status == 'A'){
                $cerrada = 'no es dia';
            }else{
                $cerrada = $caja->status;
            }
        }

        $categoria = Categoria::all();

        $config = DB::connection('client')->table('configuracions')->select('impuesto')->get();

        if ($config == '[]'){
            $config = 'vacio';
        }elseif($config == '[{"impuesto":"incluido"}]'){
            $config = 'incluido';
        }elseif ($config == '[{"impuesto":"sumado"}]'){
            $config = 'sumado';
        }

        return view('welcome',['caja' => json_encode($caja)] ,['productos' => json_encode($productos)])
            ->with(compact('cerrada', $cerrada))
            ->with(compact('categoria', $categoria))
            ->with(compact('alerta'))
            ->with(compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productos()
    {
//        $productos = DB::connection('client')->table('products')
//            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
//            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
//            ->where('products.user_id', Auth::id())->get();
//            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();
//        dd($productos);
        $productos = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
//            ->where('products.user_id', Auth::id())
            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

//        foreach($productos as $producto)
//        {
//            echo json_encode($producto);
//        }

        return response($productos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

            $idcaja = Caja::all();
            $facture = new Facture;

            $facture->date = date('Y-m-d');
            $facture->box = 'Caja No.1';
            $facture->cashier = 0;
            if ($request->has('cliente')){
                $facture->client = $request->cliente;
                $facture->puntos = $request->puntos;
            }
            if ($request->has('ticket')){
                $facture->ticket_id = $request->ticket;
            }
            $facture->brute = $request->bruto;
            $facture->desc = $request->descuento;
            $facture->itbis = $request->itbis;
            $facture->leycamarero = $request->leycamarero;
            $facture->total_facture = $request->preciop;
            $facture->Monto_tarjeta = $request->montotarjeta;
            $facture->Monto_efectivo = $request->dinero;
            $facture->returns = $request->devuelta;
            $facture->status = 'Pago';
            $facture->type_sale = 'no usada';
            $facture->type_tarject = $request->tipotarjeta;
            $facture->Numbertar = $request->Numtarjeta;
            $facture->banco = $request->banco;
            $facture->auth = $request->auth;
            $nfc = '';
            $aviso = '';
            $NFCDueDate = '';
            if ($request->setting['generacomprobante'] == 'si'){
                $facture->tipo_nfc = $request->tiponfc;

                $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");

                foreach ($headers as $header)
                {
                    $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc',$request->tiponfc);
                    foreach ($details as $detail)
                    {
                        if (($detail->actual + $detail->aviso) >= $detail->secuencia_final){
                            $aviso = "En la Solicitud #". $header->id. " Serie: ". $detail->serie. ", Tipo de NCF: ".$request->tiponfc . " Se estan agotando";
                        }
                        if ($detail->actual < $detail->secuencia_final)
                        {
                            $NFCDueDate = $header->fechavencimiento;
                            $nfc = $detail->serie."".$detail->tipo_nfc."".str_pad($detail->actual,8,"0",STR_PAD_LEFT);
                            $d = Detallesecuencia::find($detail->id);
                            $d->actual = $detail->actual+1;
                            $d->update();
                            break;
                        }
                    }
                }
                if ($nfc == '')
                {
                    return 'No es posible hacer la factura por falta de Comprobantes';
                }
                $facture->nfc = $nfc;
                if ($request->tiponfc != '02')
                {
                    $facture->telefono_nfc = $request->datancf['telefono'];
                    $facture->rnc_nfc = $request->datancf['rnc'];
                    $facture->razon_nfc = $request->datancf['razon'];
                }
            }
            $facture->caja_id = $idcaja->last()->id;
            $facture->user_id = Auth::id();
            $facture->save();



            if ($request->has('cliente')){
                $puntos = Client::all()->where('id',$request->cliente);
                if  ($puntos == '[]'){
                    $puntos  = 0;
                }else{
                    foreach ($puntos as $punto){
                        $puntos = $punto->puntos;
                    }
                }
                $total = $puntos +  $request->puntos;
                $cliente = Client::find($request->cliente);
                $cliente->puntos = $total;
                $cliente->update();
            }
            if ($request->has('ticket')){
                $tic = Puntosmovimiento::find($request->ticket);
                $tic->balancepuntos = 0;
                $tic->update();
            }

            $idfacture = DB::connection('client')->select("SELECT id FROM `factures` ORDER BY id DESC LIMIT 1");


            foreach($request->get('detalle') as $d) {

                $detalle = new Detail();

                $detalle->date = now();
                $detalle->name_product = $d["name"];
                $detalle->descuento = $d['desc'];
                $detalle->quanlity = $d["count"];
                $detalle->price = $d["price"];
                $itbisp = $d['price'] / floatval('1.'.$d['itbis']);
                if ($itbisp == $d['price']){
                    $itbisp = 0;
                }
                $bruto = floatval($itbisp) * floatval('0.'.$d['itbis']);
                $detalle->depot = $bruto;
                $detalle->impost = $itbisp;
                $detalle->product_id = $d["id"];
                $detalle->facture_id = $idfacture[0]->id;
                $detalle->save();

                if ($request->existencias == 'si')
                {
                    $producto = Product::find($d["id"]);
                    if ($producto->compuesto == 'no')
                    {
                        $producto->existence = $producto->existence - $d["count"];
                        $producto->update();
                    }
                }
            }
            DB::commit();
            return ['bien', $nfc, $idfacture[0]->id, $aviso, $NFCDueDate];

        }catch (\Exception $e){
            DB::rollBack();
            return $e;
        }
    }
    public function prueba()
    {
        $nfc = '';
        $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");
        foreach ($headers as $header)
        {
            $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc','02');
            foreach ($details as $detail)
            {
                if ($detail->actual < $detail-> secuencia_final)
                {
                    $nfc = $detail->actual;
                    return $detail->serie."".$detail->tipo_nfc."".str_pad($nfc,8,"0",STR_PAD_LEFT);
                }
            }
        }
        if ($nfc == '')
        {
            return 'No es posible hacer la factura por falta de Comprobantes';
        }
    }

    public function printPage (){
        return view('Print.print');
    }

}
