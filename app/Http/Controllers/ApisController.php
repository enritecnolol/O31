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
use Illuminate\Support\Facades\Response;


class ApisController extends Controller
{
    public function actualizarp(Request $request){

        $data = Input::all();

        return $request->img;


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
        $fecha = date("Y-m-d");
        return datatables(Facture::all()->where('date', '==', $fecha))->toJson();

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
                $product->subcategoria_id = $request->subcategoria;
                $product->update();

            }else{

                $product->name = $request->nombre;
                $product->price = $request->precio;
                $product->barcode = $request->Cbarra;
                $product->existence = 0;
                $product->impost = 0;
                $product->categoria_id = $request->categoria;
                $product->subcategoria_id = $request->subcategoria;
                $product->update();
            }
        }else{
            $product->name = $request->nombre;
            $product->price = $request->precio;
            $product->barcode = $request->Cbarra;
            $product->existence = 0;
            $product->impost = 0;
            $product->categoria_id = $request->categoria;
            $product->subcategoria_id = $request->subcategoria;
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
    public function eliminarproducto(Request $request){
        $product = Product::find($request->id);
        $product->delete();
        return 'eliminado';
    }
    public function dashboard(){
        $id = Auth::id();
        $ventassemana = DB::select("SELECT SUM(total_facture) as total FROM factures where  user_id = ".$id." AND date between date_sub(now(),INTERVAL 1 WEEK) and now()");

        if ($ventassemana == '[{"total":null}]'){
            $ventassemana = 0;
        }else{
            $ventassemana = number_format($ventassemana[0]->total);
        }


            $totalventas = DB::select("SELECT SUM(total_facture) as total FROM factures WHERE user_id = ".$id." and date BETWEEN '2018-01-01' AND '2018-12-31'");

        if ($totalventas == '[{"total":null}]'){
            $totalventas = 0;
        }else{
            $totalventas = number_format($totalventas[0]->total);
        }

        $totaldias = DB::table('factures')->select(DB::raw('SUM(total_facture) as total'))->where('date', date("Y-m-d"))->where('user_id', $id)->get();
        if ($totaldias == '[{"total":null}]'){
            $totaldias = 0;
        }else{
            $totaldias = number_format($totaldias[0]->total);
        }
        $ventasmes = DB::select("SELECT SUM(total_facture) as total FROM factures where user_id = ".$id." AND month(date) = MONTH(CURDATE())");
        if ($ventasmes == '[{"total":null}]'){
            $ventasmes = 0;
        }else{
            $ventasmes = number_format($ventasmes[0]->total);
        }

        $diasconmasventas = DB::table('factures')->select(DB::raw("(ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS diasemana, SUM(total_facture) AS cantidad"))->where('user_id', $id)->groupBy('diasemana')->get();
//        SELECT meses.id, meses.mes, IFNULL(t2.Total, 0) FROM meses LEFT JOIN (SELECT MONTH(factures.date) i, SUM(factures.total_facture) as Total FROM factures GROUP BY i) as t2 ON meses.id = t2.i
        $pormes = json_encode(DB::select('SELECT meses.id, meses.mes, IFNULL(t2.Total, 0) as cantidad FROM meses LEFT JOIN (SELECT MONTH(factures.date) i, SUM(factures.total_facture) as Total FROM factures  WHERE factures.user_id = '.$id.' GROUP BY i) as t2 ON meses.id = t2.i ORDER BY meses.id'));
//        SELECT (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) FROM factures GROUP BY DIA_SEMANA
        $productosmasvendidos = json_encode(DB::select('SELECT products.name AS nombre, COUNT(details.product_id) AS catidad FROM products, details WHERE products.id = details.product_id AND products.user_id = '.$id.' GROUP BY nombre ORDER BY catidad DESC LIMIT 5'));
//        SELECT (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) FROM factures where date between date_sub(now(),INTERVAL 1 WEEK) and now() GROUP BY DIA_SEMANA
        $ventassemanapasada = json_encode(DB::select("SELECT (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) AS total FROM factures where date between date_sub(now(),INTERVAL 1 WEEK) and now() AND factures.user_id = ".$id." GROUP BY DIA_SEMANA ORDER BY DIA_SEMANA"));
        $ventasporhoras = json_encode(DB::select("SELECT CONCAT(HOUR(DATE_FORMAT(created_at, '%h:%i:%s %p')), ':00') as hora,SUM(total_facture) as total FROM factures where user_id = ".$id." AND month(date) = MONTH(CURDATE()) GROUP BY hora ORDER BY hora desc"));


        return view('dashboard.dashboard',
            compact('totalventas'),
            compact('ventasmes'))
            ->with(compact('ventassemana'))
            ->with(compact('totaldias'))
            ->with(compact('diasconmasventas'))
            ->with(compact('pormes'))
            ->with(compact('productosmasvendidos'))
            ->with(compact('ventassemanapasada'))
            ->with(compact('ventasporhoras'));
    }

}
