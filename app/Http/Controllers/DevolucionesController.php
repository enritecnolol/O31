<?php

namespace App\Http\Controllers;

use App\Client;
use App\Configuracion;
use App\Detail;
use App\Detalle_devolucion;
use App\Detallesecuencia;
use App\Devolucion;
use App\Facture;
use App\Caja;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevolucionesController extends Controller
{
    public function index()
    {
        return view('devolucion.index');
    }
    public function buscarfactura(Request $request)
    {
        $factura = Facture::find($request->id);
        $devolucions = Devolucion::where('factura_id', $request->id)->get();

        if  ($devolucions == '[]'){
            $detall_devolucion = 'vacia';
        }else{
            $detall_devolucion = DB::connection('client')->select("SELECT factures.id, details.id, details.date, details.name_product, details.descuento, 
                            details.quanlity - IFNULL(SUM(detalle_devolucions.quanlity),0) AS quanlity, 
                            details.price - IFNULL(SUM(detalle_devolucions.price),0) AS price, 
                            details.depot - IFNULL(SUM(detalle_devolucions.itbis),0) AS depot, 
                            details.impost - IFNULL(SUM(detalle_devolucions.bruto),0) AS impost, 
                            details.product_id,
                             details.description
                            FROM factures 
                            INNER JOIN details on details.facture_id = factures.id OR details.invoice_id = factures.id 
                            LEFT JOIN devolucions ON devolucions.factura_id = factures.id
                            LEFT JOIN detalle_devolucions ON detalle_devolucions.devolucion_id = devolucions.id 
                            WHERE factures.id = ".$request->id." GROUP BY details.id");
        }
        if ($factura == ''){
            $factura = 'vacio';
            $detalle = 'vacio';
        }else{
            $detalle = Detail::all()->where('facture_id', $request->id);
            if ($detalle == '[]'){
                $detalle = Detail::all()->where('invoice_id', $request->id);
                if ($detalle == '[]') {
                    $detalle = 'vacio';
                }
            }
        }
        return [ 'factura' => $factura,
            'detalle' => $detalle,
            'detalle_devolucion' => $detall_devolucion

        ];
    }
    /*
     *
     *
     * SELECT factures.id, details.id, details.date, details.name_product, details.descuento,
details.quanlity - IFNULL(SUM(detalle_devolucions.quanlity),0) AS cantidad,
details.price - IFNULL(SUM(detalle_devolucions.price),0) AS precio,
details.depot - IFNULL(SUM(detalle_devolucions.itbis),0) AS itbis,
details.impost - IFNULL(SUM(detalle_devolucions.bruto),0) AS bruto,
details.product_id
FROM factures
INNER JOIN details on details.facture_id = factures.id
LEFT JOIN devolucions ON devolucions.factura_id = factures.id
LEFT JOIN detalle_devolucions ON detalle_devolucions.devolucion_id = devolucions.id  AND details.product_id = detalle_devolucions.product_id
WHERE factures.id = 217 GROUP BY details.id
     * */
    public function buscandoproductos(Request $request)
    {
        $producto = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
//            ->where('products.user_id', Auth::id())
            ->where('products.id', $request->id)
            ->select(DB::raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

        return $producto;
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $idcaja = Caja::all();
            $userid = Auth::id();
            $devolucion = new Devolucion();
            $bruto = 0;
            $itbis = 0;
            $TotalDevolucion = 0;
            $factura = $request->factura;

            $config = DB::connection('client')->table('configuracions')->first();

            foreach ($request->get('detalle_devolucion') as $d)
            {
                $TotalDevolucion = $TotalDevolucion + ($d['price'] * $d['cantidad']);
                $bruto = $bruto + $d['bruto'];
                $itbis = $itbis + $d['itbis'];
            }

            $devolucion->date = date('Y-m-d');
            $devolucion->client = $factura['client'];

            if ($factura['client'] != null)
            {
                $puntos = Client::all()->where('id',$factura['client']);
                if  ($puntos == '[]'){
                    $puntos  = 0;
                }else{
                    foreach ($puntos as $punto){
                        $puntos = $punto->puntos;
                    }
                }
                $resta = $puntos - $factura['puntos'];

                $cliente = Client::find($factura['client']);
                $cliente->puntos = $resta;
                $cliente->update();
            }
            $nfc = '';
            $aviso = '';
            if($config->generacomprobante == 'si')
            {
                $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");

                foreach ($headers as $header)
                {
                    $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc','04');
                    foreach ($details as $detail)
                    {
                        if (($detail->actual + $detail->aviso) >= $detail->secuencia_final){
                            $aviso = "En la Solicitud #". $header->id. " Serie: ". $detail->serie. ", Tipo de NCF: ".$detail->tipo_nfc . " Se estan agotando";
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
            }
            $devolucion->ncf = $nfc;
            $devolucion->brute = $bruto;
            $devolucion->itbis = $itbis;
            $devolucion->total_devolucion = $TotalDevolucion;
            $devolucion->factura_id = $factura['id'];
            $devolucion->caja_id = $idcaja->last()->id;
            $devolucion->user_id = $userid;
            $devolucion->save();

            $iddevolucion = Devolucion::all();

            foreach ($request->get('detalle_devolucion') as $d)
            {
                $detalle_d = new Detalle_devolucion();
                $detalle_d->date = date('Y-m-d');
                $detalle_d->name_product = $d['name_product'];
                $detalle_d->description = $d['description'];
                $detalle_d->quanlity = $d['cantidad'];
                $detalle_d->price = $d['price'];
                $detalle_d->itbis = $d['itbis'];
                $detalle_d->bruto = $d['bruto'];
                $detalle_d->product_id = $d['product_id'];
                $detalle_d->devolucion_id = $iddevolucion->last()->id;
                $detalle_d->user_id = $userid;
                $detalle_d->save();

                $existencias = Configuracion::all();
                foreach($existencias as $existencia)
                {
                    $existencia = $existencia->controlinv;
                }
                if ($existencia == 'si')
                {
                    $product = Product::find($d['product_id']);
                    $product->existence = $product->existence + $d['cantidad'];
                    $product->update();
                }

            }
            $compania = Configuracion::all();
            DB::commit();
            return [$compania, $TotalDevolucion, date('d-m-Y'), $iddevolucion->last()->id, $nfc, $aviso];

        }catch (\Exception $exception)
        {
            DB::rollBack();
            return response()->json($exception, 400);
        }

    }
}
