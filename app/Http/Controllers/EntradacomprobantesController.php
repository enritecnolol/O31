<?php

namespace App\Http\Controllers;

use App\Detallesecuencia;
use App\Entradacomprobantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntradacomprobantesController extends Controller
{
    public function store(Request $request)
    {
        $entradacomprobante = new Entradacomprobantes();
        $entradacomprobante->tiponcf_id = $request->ncf;
        if ($request->setting['generacomprobante'] == 'si'){
            $nfc = '';
            $aviso = '';
            $headers = DB::select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento AND user_id =".Auth::id()."");
            foreach ($headers as $header)
            {
                $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc',$request->ncf);
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
            $entradacomprobante->nfc_nfc = $nfc;
//            $facture->nfc = ;
            if ($request->tiponfc != '02')
            {
                $entradacomprobante->telefono_nfc = $request->telefono_nfc;
                $entradacomprobante->rnc_nfc = $request->rnc_nfc;
                $entradacomprobante->razon_nfc = $request->razon_nfc;
            }
        }
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
        return ['guardado', $nfc, $aviso];
    }

    public function comprobanteporprovedor(Request $request)
    {
        $comprobante = Entradacomprobantes::all()->where('suplidor_id', $request->id)->where('balance', '>', 0)->where("user_id", Auth::id());
        if ($comprobante == '[]') {
            $comprobante = 'no resultado';
        }
        return $comprobante;
    }
    public function datarnc(Request $request){
        $rnc = DB::select("SELECT telefono_nfc, rnc_nfc, razon_nfc FROM entradacomprobantes WHERE rnc_nfc = ".$request->rnc." and user_id = ".Auth::id()." LIMIT 1");
        return $rnc;
    }

}
