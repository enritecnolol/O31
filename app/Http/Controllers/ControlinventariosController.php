<?php

namespace App\Http\Controllers;

use App\Compra;
use App\Detalle_compra;
use Illuminate\Http\Request;
use App\Configuracion;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ControlinventariosController extends Controller
{
    public function index()
    {
        return view('inventario.index');
    }

    public  function todosproductos()
    {
        $productos = Product::where('compuesto', 'no')->get();
        return $productos;
    }
    public function storecompra(Request $request)
    {
        DB::connection('client')->begintransaction();
        try{

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
                $detalle->cantidad = $pc['cantidad_comprada'];
                $detalle->precio_compra = $pc['precio_compra'];
                $detalle->compra_id = $idcompra->last()->id;
                $detalle->user_id = Auth::id();
                $detalle->save();

                $product = Product::find($pc['id']);
                $product->existence = $product->existence + $pc['cantidad_comprada'];
                $product->update();
            }
            DB::connection('client')->commit();

            return 'guardado';

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }
    }
}
