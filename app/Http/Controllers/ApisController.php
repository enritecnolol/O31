<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Facture;
use Illuminate\Database\Eloquent;

class ApisController extends Controller
{
    public function actualizarp(){

        $data = Input::all()["data"];
        $id = $data["id"];
        $producto = Product::where('id', $id)->first();
        $producto->name = $data["name"];
        $producto->price = $data["price"];
        $producto->img = $data["img"];
        $producto->barcode = $data["barcode"];
        $producto->status = $data["status"];
        $producto->existence = $data["existence"];
        $producto->impost = $data["impost"];
        $producto->update();
        return 'Actualizado';

    }

    public function historico(){
        $caja = Caja::all()->where('fecha_apertura', '==', date('Y-m-d'))->where('status', '==', 'A');

        if ($caja == '[]'){
            $id = 0;
        }else{
            foreach ($caja as $caja){
                $id = $caja->id;
            }
        }
        return datatables(Facture::all()->where('date', '==', date('Y-m-d'))->where('caja_id', '==', $id))->toJson();

    }
    public function buscarproducto(){
            $data = Input::all();
            $producto = $data["producto"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
            $productos = DB::table('products')->where('name', 'like', '%'.$producto.'%')->get();
            return $productos;
    }
    public function buscarproductoreferencia(){
            $data = Input::all();
            $referencia = $data["referenciah"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
            $product = DB::table('products')->where('barcode', 'like', '%'.$referencia.'%')->get();
            return $product;
    }

    public function buscarp(){
            $data = Input::all();
            $producto = $data["producto"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
            $productos = DB::table('products')->where('name', 'like', '%'.$producto.'%')->get();
            return $productos;
    }

}
