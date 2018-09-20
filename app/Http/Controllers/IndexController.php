<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Facture;
use App\Product;
use DemeterChain\C;
use Illuminate\Http\Request;

class IndexController extends Controller
{
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
            $cerrada = $caja[0]["status"];
        }
//        return $cerrada;

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

        $facture = new Facture;
        $facture->date = date('Y-m-d');
//        $facture->time = date('h:m:s');
        $facture->box = 'Caja No.1';
        $facture->cashier = 0;
        $facture->client = $request->cliente;
        $facture->brute = 0;
        $facture->desc = 0;
        $facture->itbis = 0;
        $facture->total_facture = $request->preciop;
        $facture->status = 'Pago';
        $facture->type_sale = 'contado';
        $facture->impost = 0;
        $facture->save();

        $idfacture = Facture::all();

        foreach ($request->get('detalle') as $d) {
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
            $detalle->save();
        }

    }

}
