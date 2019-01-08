<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Details_orden;
use App\Facture;
use App\Mesa_temp;
use App\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdensController extends Controller
{
    public function store(Request $request)
    {
        $orden = new Orden();
        foreach ($request->get('productos') as $producto)
        {
            if ($producto['id'] == 0 && empty($producto['orden']))
            {
                $orden->mesa_id = $request->mesa;
                $orden->num_invitado = $request->invitados;
                $orden->estado = 'Abierta';
                $orden->subtotal = $request->subtotal;
                $orden->fecha_apertura = now();
                $orden->user_id = Auth::id();
                $orden->save();

                $idorden = Orden::all()->where('user_id', Auth::id());

                $details = new Details_orden();
                if ($producto['orden'])
                {
                    $details->orden_id = $producto['orden']['id'];
                }else{
                    $details->orden_id = $idorden->last()->id;
                }
                $details->product_id = $producto['producto']['id'];
                $details->cantidad = $producto['cantidad'];
                $itbisp = $producto['producto']['price'] / floatval('1.'.$producto['producto']['porciento']);
                if ($itbisp == $producto['producto']['price']){
                    $itbisp = 0;
                }else{
                    $itbisp = $itbisp;
                }
                $bruto = floatval($itbisp) * floatval('0.'.$producto['producto']['porciento']);
                if ($bruto ==0)
                {
                    $bruto = $producto['cantidad'] * $producto['producto']['price'];
                }
                $details->itbis = $bruto;
                $details->bruto = $itbisp;
                $details->user_id = Auth::id();
                $details->save();
            }else{
                if ($producto['id'] == 0)
                {
                    $details = new Details_orden();
                    $details->orden_id = $producto['orden']['id'];
                    $details->product_id = $producto['producto']['id'];
                    $details->cantidad = $producto['cantidad'];
                    $itbisp = $producto['producto']['price'] / floatval('1.'.$producto['producto']['porciento']);
                    if ($itbisp == $producto['producto']['price']){
                        $itbisp = 0;
                    }else{
                        $itbisp = $itbisp;
                    }
                    $bruto = floatval($itbisp) * floatval('0.'.$producto['producto']['porciento']);
                    if ($bruto ==0)
                    {
                        $bruto = $producto['cantidad'] * $producto['producto']['price'];
                    }
                    $details->itbis = $bruto;
                    $details->bruto = $itbisp;
                    $details->user_id = Auth::id();
                    $details->save();

                }else{
                    $detailsedit = Details_orden::find($producto['id']);
                    $detailsedit->cantidad = $producto['cantidad'];
                    $itbisp2 = $producto['producto']['price'] / floatval('1.'.$producto['producto']['porciento']);
                    if ($itbisp2 == $producto['producto']['price']){
                        $itbisp2 = 0;
                    }

                    $bruto = floatval($itbisp2) * floatval('0.'.$producto['producto']['porciento']);
                    if ($bruto ==0)
                    {
                        $bruto = $producto['cantidad'] * $producto['producto']['price'];
                    }
                    $detailsedit->itbis = $bruto;
                    $detailsedit->bruto = $itbisp2;
                    $detailsedit->update();
                }
            }
        }
    }
    public function cambiarcantidad(Request $request)
    {
        $orden = Orden::find($request->orden);
        $orden->subtotal = $request->subtotal;
        $orden->update();

        $detailsedit = Details_orden::find($request->producto['id']);
        $detailsedit->cantidad = $request->producto['cantidad'];
        $precio = $request->producto['cantidad'] *$request->producto['producto']['price'];
        $itbisp2 =$precio / floatval('1.'.$request->producto['producto']['porciento']);
        if ($itbisp2 == $precio){
            $itbisp2 = 0;
        }
        $bruto = floatval($itbisp2) * floatval('0.'.$request->producto['producto']['porciento']);
        if ($bruto ==0)
        {
            $bruto = $request->producto['cantidad'] * $request->producto['producto']['price'];
        }
        $detailsedit->itbis = $bruto;
        $detailsedit->bruto = $itbisp2;
        $detailsedit->update();
        return 'save';
    }
    public function eliminarprod(Request $request)
    {
        $detailsedit = Details_orden::find($request->producto['id']);
        $detailsedit->delete();

        $orden = Orden::find($request->orden);
        $orden->subtotal = $request->subtotal;
        $orden->update();

        return 'delete';

    }
    public function cancelarorden(Request $request)
    {
        $mesa_temps = Mesa_temp::all()->where('coroto_id', $request->mesa);
        foreach ($mesa_temps as $mesa_temp)
        {
            $mesa_temp = $mesa_temp->id;
            $mesa_tempsdelete = Mesa_temp::find($mesa_temp);
            $mesa_tempsdelete->delete();
        }

        $ordens = Orden::all()->where('estado', 'Abierta')->where('mesa_id', $request->mesa);
        foreach ($ordens as $orden)
        {
            $detail_ordens = Details_orden::all()->where('orden_id', $orden->id);
            foreach ($detail_ordens as $detail_orden)
            {
                $detail_ordendelete = Details_orden::find($detail_orden->id);
                $detail_ordendelete->delete();
            }
            $ordensde = Orden::find($orden->id);
            $ordensde->delete();

        }
        return 'delete';

    }
    public function facturarorden(Request $request)
    {
        $idcaja = Caja::all();
        $facture = new Facture;
        $facture->date = date('Y-m-d');
        $facture->box = 'Caja No.1';
        $facture->cashier = 0;
        $facture->brute = $request->bruto;
        $facture->desc = $request->descuento;
        $facture->itbis = $request->itbis;
        $facture->total_facture = $request->neto;
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
        $idfacture = Facture::all();

        $count = 0;

        foreach ($request->get('detalle') as $d) {
            $count++;

            $detalle = new Detail;

            $detalle->date = now();
            $detalle->name_product = $d["producto"]["name"];
            $detalle->descuento = 0;
            $detalle->quanlity = $d["cantidad"];
            $detalle->price = $d["total"];
            $itbisp = $d['total'] / floatval('1.'.$d["producto"]['porciento']);
            if ($itbisp == $d['total']){
                $itbisp = 0;
            }else{
                $itbisp = $itbisp;
            }
            $bruto = floatval($itbisp) * floatval('0.'.$d["producto"]['porciento']);
            $detalle->depot = $bruto;
            $detalle->impost = $itbisp;
            $detalle->product_id = $d["producto"]["id"];
            $detalle->facture_id = $idfacture->last()->id;
            $detalle->save();

            $orden = Orden::find($d["orden"]["id"]);
            $orden->estado = "Cerrada";
            $orden->fecha_cierre = now();
            $orden->update();
        }

        $mesa_temps = Mesa_temp::all()->where('coroto_id', $request->mesa);
        foreach ($mesa_temps as $mesa_temp)
        {
            $mesa_tempsdelete = Mesa_temp::find($mesa_temp->id);
            $mesa_tempsdelete->delete();
        }

        return $mesa_temps;
    }
    public function Comanda()
    {
        return view('comanda');
    }
}
