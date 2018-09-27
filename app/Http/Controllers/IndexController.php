<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Facture;
use App\Product;
use DemeterChain\C;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $caja = Caja::all()->where('fecha_apertura', '==', date("Y-m-d"));
        $productos = Product::all();
        if ($caja == '[]'){
            $cerrada = 'C';
        }else{
            foreach ($caja as $cerrada){
                $cerrada = $cerrada["status"];
            }
        }

        return view('welcome', ['productos' => json_encode($productos)], ['caja' => json_encode($caja)])->with(compact('cerrada', $cerrada));
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
        $facture->client = $request->cliente;
        $facture->brute = 0;
        $facture->desc = 0;
        $facture->itbis = 0;
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
        $facture->save();

        $idfacture = Facture::all();

        $count = 0;

        foreach ($request->get('detalle') as $d) {

            $count++;

            $detalle = new Detail;

            $detalle->date = now();
            $detalle->name_product = $d["name"];
            $detalle->unity_sale = 0;
            $detalle->quanlity = $d["count"];
            $detalle->price = $d["price"];
            $detalle->depot = 0;
            $detalle->impost = 0;
            $detalle->product_id = $d["id"];
            $detalle->facture_id = $idfacture->last()->id;


            $id = $d["id"];
            $product = DB::table('products')->select('existence')->where('id', $id)->first();
            $existencia = $product->existence;
            $resta = $existencia - $d["count"];


            if ($resta < 0){
                $resta = 0;
                $productupdate = Product::where('id', $d["id"])->first();
                $productupdate->existence = $resta;
                $productupdate->update();

//

            }else{

                $productupdate = Product::where('id', $d["id"])->first();
                $productupdate->existence = $resta;
                $productupdate->update();

            }

            $detalle->save();

        }
        return 'bien';
        echo $count;

    }

}
