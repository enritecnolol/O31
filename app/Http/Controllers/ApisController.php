<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Categoria;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Facture;
use Illuminate\Database\Eloquent;
use Validator;


class ApisController extends Controller
{
    public function actualizarp(Request $request){

        $data = Input::all();

        return $request->img;

        dd($request);

        $file = $request->file('img');
        $file->storeAs('/', $file->getClientOriginalName());
        if (Input::hasFile('img')){
            $id = $data["data"]["id"];
            $producto = Product::where('id', $id)->first();
            $producto->name = $data["data"]["name"];
            $producto->price = $data["data"]["price"];
            $producto->img = $data["data"]["img"];
            $producto->barcode = $data["data"]["barcode"];
            $producto->status = $data["data"]["status"];
            $producto->existence = $data["data"]["existence"];
            $producto->impost = $data["data"]["impost"];
            $producto->update();
            return 'tiene';
        }else{

            $id = $data["data"]["id"];
            $producto = Product::where('id', $id)->first();
            $producto->name = $data["data"]["name"];
            $producto->price = $data["data"]["price"];
            $producto->img = $data["data"]["img"];
            $producto->barcode = $data["data"]["barcode"];
            $producto->status = $data["data"]["status"];
            $producto->existence = $data["data"]["existence"];
            $producto->impost = $data["data"]["impost"];
            $producto->update();
            return 'no tiene';
        }
    }


    public function historico(){

        return datatables(Facture::all())->toJson();

    }
    public function ventasbusqueda(){
        $ida = Auth::id();
        $caja = DB::table('cajas')->select('id')->where('fecha_apertura', date("Y-m-d"))->where('status', 'A')->where('user_id',$ida)->latest()->take(1)->get();
        $id = $caja[0]->id;
        $data = Input::all();
        $fecha = $data["fecha"];

        $factures = DB::table('factures')->where('date', $fecha)->get();

        return $factures;

    }

    public function buscarproducto(){
        $id = Auth::id();
        $data = Input::all();
        $producto = $data["producto"];
        $productos = DB::table('products')->where('name', 'like', '%'.$producto.'%')->get();
        return $productos;
    }
    public function buscarproductoreferencia(){
        $id = Auth::id();
        $data = Input::all();
        $referencia = $data["referenciah"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
        $product = DB::table('products')->where('barcode', 'like', '%'.$referencia.'%')->get();
        return $product;
    }

    public function buscarp(){
        $id = Auth::id();
        $data = Input::all();
        $producto = $data["producto"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
        $productos = DB::table('products')->where('name', 'like', '%'.$producto.'%')->get();
        return $productos;
    }


    public function update(Request $request){

        $id = $request->id;
        $product = Product::find($id);

        if ($request->hasFile('img')){
            if ($request->hasFile('img')){
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());
                $product->name = $request->nombre;
                $product->price = $request->precio;
                $product->barcode = $request->Cbarra;
                $product->img = $file->getClientOriginalName();;
                $product->existence = 0;
                $product->impost = 0;
                $product->categoria_id = $request->categoria;
                $product->update();

            }else{

                $product->name = $request->nombre;
                $product->price = $request->precio;
                $product->barcode = $request->Cbarra;
                $product->existence = 0;
                $product->impost = 0;
                $product->categoria_id = $request->categoria;
                $product->update();
            }
        }else{
            $product->name = $request->nombre;
            $product->price = $request->precio;
            $product->barcode = $request->Cbarra;
            $product->existence = 0;
            $product->impost = 0;
            $product->categoria_id = $request->categoria;
            $product->update();
        }
        return redirect('/productos');
    }
    public function cuadres(){

        $id = Auth::id();
        $caja = Caja::all()->where('user_id', '==', $id);

        return $caja;

    }
    public function buscarcuadre(){
        $id = Auth::id();
        $data = Input::all();
        $fecha = $data["fecha"];
        $caja = DB::table('cajas')->where('fecha_apertura', $fecha)->where('user_id', $id)->get();
        return $caja;
    }

    public function crearcategoriarapida(Request $request){

        $data = $this->validate($request, [
            'nombre' => 'required|unique:categorias|max:255',
            'codigo' => 'required|unique:categorias',
        ]);


        $categoria = new Categoria;

        $categoria->nombre = $data["nombre"];
        $categoria->codigo = $data["codigo"];
        $categoria->img = 'default.jpg';
        $categoria->user_id = Auth::id();
        $categoria->save();

        return 'guardado';



    }
    public function cargarcategoria(){
        $id = Auth::id();
        $categoria = Categoria::all()->where('user_id', '==', $id);

        return $categoria;
    }
    public function productos(){
        return datatables(Product::all()->where('user_id', '==', Auth::id()))->toJson();
    }

    public function productoscategoria(Request $request){
        return $request;
    }

    public function productosporcategoria(Request $request){

        $productos = Product::all()->where('categoria_id', '==', $request->id)->where('user_id', '==', Auth::id());
        return $productos;
    }

}
