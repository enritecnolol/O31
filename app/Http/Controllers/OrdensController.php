<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Detail;
use App\Details_orden;
use App\Detallesecuencia;
use App\Events\NewOrdenNotification;
use App\Facture;
use App\Mesa_temp;
use App\Orden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                $orden->camarero = $request->camarero;
                $orden->fecha_apertura = now();
                $orden->user_id = Auth::id();
                $orden->save();

                $idorden = Orden::all();

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
                $details->camarero = $request->camarero;
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
                    $details->camarero = $request->camarero;
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
        broadcast(new NewOrdenNotification($orden, $request->get('productos')));
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
        broadcast(new NewOrdenNotification($orden, $detailsedit));
        return 'save';
    }
    public function eliminarprod(Request $request)
    {
        $detailsedit = Details_orden::find($request->producto['id']);
        $detailsedit->delete();

        $orden = Orden::find($request->orden);
        $orden->subtotal = $request->subtotal;
        $orden->update();

        broadcast(new NewOrdenNotification($orden, $detailsedit));
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
        if (empty($ordens))
        {
            broadcast(new NewOrdenNotification($ordens, $detail_ordens));
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
        $facture->type_sale = 'express';
        $facture->type_tarject = $request->tipotarjeta;
        $facture->Numbertar = $request->Numtarjeta;
        $facture->banco = $request->banco;
        $facture->auth = $request->auth;
        $nfc = '';
        $aviso = '';
        if ($request->setting['generacomprobante'] == 'si'){
            $facture->tipo_nfc = $request->tiponfc;

            $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento ");
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
//            $facture->nfc = ;
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

        broadcast(new NewOrdenNotification($orden, $request->dinero));

        return ['bien', $nfc, $idfacture->last()->id, $aviso];
    }
    public function Comanda()
    {
        return view('comanda');
    }
    public function viewprepararordenes()
    {
        return view('comandaordenes');
    }
    public function allordenesabiertas()
    {
//        $ordenes = Orden::all()->where('estado', 'Abierta');
        $ordenes = DB::select("SELECT ordens.*, corotos.name FROM ordens, corotos WHERE ordens.estado = 'Abierta' AND ordens.mesa_id = corotos.id ORDER BY ordens.id ASC");
        return $ordenes;
    }
    public function allordenesdetalle(Request $request)
    {
//        $detalle = Details_orden::all()->where('orden_id', $request->id);
        $detalle = DB::select("SELECT details_ordens.*, products.name, products.compuesto FROM details_ordens , products WHERE details_ordens.product_id = products.id and details_ordens.orden_id =".$request->id."");
        return $detalle;
    }
    public function cambioestadoordenitem(Request $request)
    {
        $detalle = Details_orden::find($request->id);
        $detalle->estado = 'preparando';
        $detalle->update();
        return 'guardado';
    }
}
