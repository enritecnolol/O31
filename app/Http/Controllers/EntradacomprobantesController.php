<?php

namespace App\Http\Controllers;

use App\Entradacomprobantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntradacomprobantesController extends Controller
{
    public function store(Request $request)
    {
        $entradacomprobante = new Entradacomprobantes();
        $entradacomprobante->tiponcf_id = $request->ncf;
        $entradacomprobante->tipofactura_id = $request->tfactura;
        $entradacomprobante->suplidor_id = $request->suplidor;
        $entradacomprobante->emisiorrnc = $request->emisorrnc;
        $entradacomprobante->emisiorfactura = $request->emisorfactura;
        $entradacomprobante->factura_ref = $request->factura_ref;
        $entradacomprobante->date = $request->fecha;
        $entradacomprobante->ncf = $request->ncfno;
        $entradacomprobante->tipogasto = $request->tipogasto;
        $entradacomprobante->condiciones = $request->condiciones;
        $entradacomprobante->concepto = $request->concepto;
        $entradacomprobante->formaapgo = $request->formapago;
        $entradacomprobante->subtotal = $request->subtotal;
        $entradacomprobante->descuento = $request->descuento;
        $entradacomprobante->itbispagado = $request->itbispagado;
        $entradacomprobante->flete = $request->flete;
        $entradacomprobante->netototal = $request->netototal;
        $entradacomprobante->balance = $request->netototal;
        $entradacomprobante->user_id = Auth::id();
        $entradacomprobante->save();
        return 'Guardado';
    }

    public function comprobanteporprovedor(Request $request)
    {
        $comprobante = Entradacomprobantes::all()->where('suplidor_id', $request->id)->where('balance', '>', 0);
        if ($comprobante == '[]') {
            $comprobante = 'no resultado';
        }
        return $comprobante;
    }

}
