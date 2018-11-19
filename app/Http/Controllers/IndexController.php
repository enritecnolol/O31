<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Categoria;
use App\Client;
use App\Configuracion;
use App\Detail;
use App\Facture;
use App\Product;
use App\Puntosmovimiento;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        $caja = Caja::all()->where('user_id','==',$id)->last();
        $productos = DB::table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->where('products.user_id', $id)
            ->select(DB::raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

        if ($caja == '[]'){
            $cerrada = 'C';
        }if($caja->fecha_apertura != date("Y-m-d") and $caja->status == 'A'){
            $cerrada = 'no es dia';
        }else{
            $cerrada = $caja->status;
        }
        $categoria = Categoria::all()->where('user_id', '==', $id);

        $config = DB::table('configuracions')->select('impuesto')->where('user_id', $id)->get();

        if ($config == '[]'){
            $config = 'vacio';
        }elseif($config == '[{"impuesto":"incluido"}]'){
            $config = 'incluido';
        }elseif ($config == '[{"impuesto":"sumado"}]'){
            $config = 'sumado';
        }

        return view('welcome', ['productos' => json_encode($productos)], ['caja' => json_encode($caja)])
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        $idfacture = Facture::all();

        $count = 0;

        foreach ($request->get('detalle') as $d) {

            $count++;

            $detalle = new Detail;

            $detalle->date = now();
            $detalle->name_product = $d["name"];
            $detalle->descuento = $d['desc'];
            $detalle->quanlity = $d["count"];
            $detalle->price = $d["price"];
            $itbisp = $d['price'] / floatval('1.'.$d['itbis']);
            if ($itbisp == $d['price']){
                $itbisp = 0;
            }else{
                $itbisp = $itbisp;
            }
            $bruto = floatval($itbisp) * floatval('0.'.$d['itbis']);
            $detalle->depot = $bruto;
            $detalle->impost = $itbisp;
            $detalle->product_id = $d["id"];
            $detalle->facture_id = $idfacture->last()->id;
            $detalle->save();

        }
        return 'bien';
        echo $count;

    }

}
