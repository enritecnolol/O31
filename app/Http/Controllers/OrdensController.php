<?php

namespace App\Http\Controllers;

use App\Details_orden;
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
}
