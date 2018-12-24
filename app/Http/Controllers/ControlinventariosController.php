<?php

namespace App\Http\Controllers;

use App\Compra;
use App\Detalle_compra;
use Illuminate\Http\Request;
use App\Configuracion;
use App\Product;
use Illuminate\Support\Facades\Auth;
class ControlinventariosController extends Controller
{
    public function index()
    {
        return view('inventario.index');
    }

    public  function todosproductos()
    {
        $productos = Product::all()->where('user_id', Auth::id());
        return $productos;
    }
    public function storecompra(Request $request)
    {
        $compra = new Compra();
        $compra->fecha = $request->fecha;
        $compra->vendedor = $request->vendedor;
        $compra->cantidad = $request->cantidad;
        $compra->nota = $request->nota;
        $compra->user_id = Auth::id();
        $compra->save();

        $idcompra = Compra::all();

        foreach ($request->get('productoscomprados') as $pc)
        {
            $detalle = new Detalle_compra();
            $detalle->fecha = $request->fecha;
            $detalle->product_id = $pc['id'];
            $detalle->cantidad = $pc['status'];
            $detalle->cantidad = $pc['status'];
            $detalle->compra_id = $idcompra->last()->id;
            $detalle->user_id = Auth::id();
            $detalle->save();

            $product = Product::find($pc['id']);
            $product->existence = $product->existence + $pc['status'];
            $product->update();
        }
        return 'guardado';
    }
}
