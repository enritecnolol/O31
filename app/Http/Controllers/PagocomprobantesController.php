<?php

namespace App\Http\Controllers;

use App\Entradacomprobantes;
use App\Pagocomprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagocomprobantesController extends Controller
{
    public function store(Request $request)
    {
        $pago = new Pagocomprobante();
        $pago->fecha = date('Y-m-d');
        $pago->entradacomprobante_id = $request->idcomprobante;
        $pago->balance = $request->balance;
        $pago->montopagado = $request->montopagado;
        $pago->suplidor_id = $request->suplidor;
        $pago->user_id = Auth::id();
        $pago->save();

        $comprobante = Entradacomprobantes::find($request->idcomprobante);
        $comprobante->balance = $request->balance;
        $comprobante->update();

    }
}
