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
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function actualizarp(Request $request){

        $data = Input::all();

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
        $caja = DB::connection('client')->table('cajas')->select('id')->where('fecha_apertura', date("Y-m-d"))->where('status', 'A')->latest()->take(1)->get();
        $id = $caja[0]->id;
        $data = Input::all();
        $fecha = $data["fecha"];

        $factures = DB::connection('client')->table('factures')->where('date', $fecha)->get();

        return $factures;

    }

    public function buscarproducto(){
        $id = Auth::id();
        $data = Input::all();
        $producto = $data["producto"];
        $productos = DB::connection('client')->table('products')->where('name', 'like', '%'.$producto.'%')->get();
        return $productos;
    }
    public function buscarproductoordenes(){
        $id = Auth::id();
        $data = Input::all();
        $producto = $data["producto"];
        $productos = DB::connection('client')->table('products')->where('name', 'like', '%'.$producto.'%')->get();
        return $productos;
    }
    public function buscarproductoreferencia(){
        $id = Auth::id();
        $data = Input::all();
        $referencia = $data["referenciah"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
        $product = DB::connection('client')->table('products')->where('barcode', 'like', '%'.$referencia.'%')->get();
        return $product;
    }

    public function buscarp(){
        $id = Auth::id();
        $data = Input::all();
        $producto = $data["producto"];
//            $productos = Product::all()->where('name', 'LIKE', '%' . $producto . '%');
        $productos = DB::connection('client')->table('products')->where('name', 'like', '%'.$producto.'%')->get();
        return $productos;
    }


    public function update(Request $request){
        DB::connection('client')->beginTransaction();
        try{

            $id = $request->id;
            $product = Product::find($id);

            if ($request->has('refimpuestoid') == 0){
                $itbis = 'no';
            }else{
                $itbis = 'si';
            }

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());
                $product->img = $file->getClientOriginalName();
            }
            $product->name = $request->nombre;
            $product->price = $request->precio;
            $product->cost = $request->cost;
            $product->barcode = $request->barcode;
            $product->impost = 0;
            $product->impuestoref_id = $request->refimpuestoid;
            $product->itbis = $itbis;
            $product->categoria_id = $request->categoria;
            $product->subcategoria_id = $request->subcategoria;
            $product->compuesto = $request->compuesto;
            $product->estado = $request->estado;
            $product->sale_config = $request->saleConfig;
            $product->service_config = $request->serviceConfig;
            $product->inventory_config = $request->inventoryConfig;
            $product->purchase_config = $request->purchaseConfig;
            $product->update();

            DB::connection('client')->commit();
            return response()->json(["message"=> "Este producto ha sido editado con exito"], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }
    public function cuadres(){

        $id = Auth::id();
//        $caja = Caja::all()->where('user_id', '==', $id)->orderBy('id', 'desc');
        $caja = DB::connection('client')->table('cajas')->orderBy('id', 'desc')->get();
        return $caja;

    }
    public function buscarcuadre(){
        $id = Auth::id();
        $data = Input::all();
        $fecha = $data["fecha"];
        $caja = DB::connection('client')->table('cajas')->where('fecha_apertura', $fecha)->get();
        return $caja;
    }

    public function crearcategoriarapida(Request $request){

//        $data = $this->validate($request, [
//            'nombre' => 'required|unique:categorias|max:255',
//            'codigo' => 'required|unique:categorias'
//        ]);

        $categoria = new Categoria;

        $categoria->nombre = $request["nombre"];
        $categoria->codigo = $request["codigo"];
        $categoria->img = 'default.jpg';
        $categoria->user_id = Auth::id();
        $categoria->save();

        return 'guardado';

    }
    public function cargarcategoria(){
        $id = Auth::id();
        $categoria = Categoria::all();

        return $categoria;
    }
    public function productos(){
        return datatables(Product::all())->toJson();
    }

    public function productoscategoria(Request $request){
        return $request;
    }

    public function productosporcategoria(Request $request){

        $productos = Product::all()->where('categoria_id', '==', $request->id);
        if ($request->id == 0)
        {
            $productos = Product::all();
        }
        return $productos;
    }
    public function productosporcategoriaordenes(Request $request){

//        $productos = Product::all()->where('categoria_id', '==', $request->id)->where('user_id', '==', Auth::id());
        $id = Auth::id();
        $productos = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->where('products.categoria_id', $request->id)
            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

        if ($request->id == 0)
        {
            $productos = Product::all();
            $productos = DB::connection('client')->table('products')
                ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
                ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
//                ->where('products.user_id', $id)
                ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();
        }
        return $productos;
    }
    public function eliminarproducto(Request $request){

        $product = Product::find($request->id);
        $product->estado = false;
        $product->update();

        return response()->json(['message' => "Este producto ha sido desactivado"], 200);
    }
    public function dashboard(){

        $StartThisYear = date("Y")."-01-01";
        $EndThisYear = date("Y")."-12-31";

        // Select de ventas , devolucion y neto

        $resumenDia = DB::connection('client')
            ->table('factures')
            ->leftJoin('devolucions', 'factures.id', '=', 'devolucions.factura_id')
            ->select(DB::raw('sum(ifnull(total_devolucion,0)) as total_devuelto, ifnull(SUM(total_facture),0) as venta_total, ifnull(SUM(total_facture),0) - sum(ifnull(total_devolucion,0)) as total_neto'))
            ->where('factures.date', date("Y-m-d"))->first();

        $resumenSemana = DB::connection('client')
            ->table('factures')
            ->leftJoin('devolucions', 'factures.id', '=', 'devolucions.factura_id')
            ->whereRaw('factures.date between date_sub(now(),INTERVAL 1 WEEK) and now()')
            ->select(DB::raw('sum(ifnull(total_devolucion,0)) as total_devuelto, ifnull(SUM(total_facture),0) as venta_total, ifnull(SUM(total_facture),0) - sum(ifnull(total_devolucion,0)) as total_neto'))
            ->first();

        $resumenMes = DB::connection('client')
            ->table('factures')
            ->leftJoin('devolucions', 'factures.id', '=', 'devolucions.factura_id')
            ->whereRaw('month(factures.date) = MONTH(CURDATE()) and year(factures.date) = year(CURDATE())')
            ->select(DB::raw('sum(ifnull(total_devolucion,0)) as total_devuelto, ifnull(SUM(total_facture),0) as venta_total, ifnull(SUM(total_facture),0) - sum(ifnull(total_devolucion,0)) as total_neto'))
            ->first();

        $resumenYear = DB::connection('client')
            ->table('factures')
            ->leftJoin('devolucions', 'factures.id', '=', 'devolucions.factura_id')
            ->whereBetween('factures.date', [$StartThisYear, $EndThisYear])
            ->select(DB::raw('sum(ifnull(total_devolucion,0)) as total_devuelto, ifnull(SUM(total_facture),0) as venta_total, ifnull(SUM(total_facture),0) - sum(ifnull(total_devolucion,0)) as total_neto'))
            ->first();

//
        $diasconmasventas = json_encode(DB::connection('client')->select("SELECT (ELT(WEEKDAY(date) + 1, '1', '2', '3', '4', '5', '6', '7')) AS dia,(ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) AS total FROM factures where (date between  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() )    GROUP BY DIA_SEMANA, dia ORDER BY `dia` ASC"));
//        SELECT meses.id, meses.mes, IFNULL(t2.Total, 0) FROM meses LEFT JOIN (SELECT MONTH(factures.date) i, SUM(factures.total_facture) as Total FROM factures GROUP BY i) as t2 ON meses.id = t2.i
        $pormes = json_encode(DB::connection('client')->select("SELECT meses.id, meses.mes, IFNULL(t2.Total, 0) as cantidad FROM meses LEFT JOIN (SELECT MONTH(factures.date) i, SUM(factures.total_facture) as Total FROM factures  WHERE  (date between  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() ) GROUP BY i) as t2 ON meses.id = t2.i ORDER BY meses.id"));
//        SELECT (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) FROM factures GROUP BY DIA_SEMANA
        $productosmasvendidos = json_encode(DB::connection('client')->select("SELECT products.name AS nombre, sum(details.price) AS catidad FROM products, details WHERE products.id = details.product_id AND (date between  DATE_FORMAT(NOW() ,'%Y-01-01') AND NOW() ) GROUP BY nombre ORDER BY catidad DESC LIMIT 5"));
//        SELECT (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) FROM factures where date between date_sub(now(),INTERVAL 1 WEEK) and now() GROUP BY DIA_SEMANA
        $ventassemanapasada = json_encode(DB::connection('client')->select("SELECT (ELT(WEEKDAY(date) + 1, 1, 2, 3, 4, 5, 6, 7)) AS DIA, (ELT(WEEKDAY(date) + 1, 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo')) AS DIA_SEMANA, SUM(total_facture) AS total FROM factures where date between date_sub(now(),INTERVAL 1 WEEK) and now() GROUP BY date ORDER BY `DIA` ASC"));
        $ventasporhoras = json_encode(DB::connection('client')->select("SELECT HOUR(created_at) AS horaa ,DATE_FORMAT(created_at, '%h %p') as hora,SUM(total_facture) as total FROM factures where month(date) = MONTH(CURDATE()) GROUP BY hora,horaa ORDER BY `horaa` ASC"));

        $graficogrande = json_encode(DB::connection('client')->select("SELECT date, SUM(factures.total_facture) as total FROM factures GROUP BY date"));
//
        return view('dashboard.dashboard')
            ->with(compact('resumenDia'))
            ->with(compact('resumenSemana'))
            ->with(compact('resumenMes'))
            ->with(compact('resumenYear'))
            ->with(compact('diasconmasventas'))
            ->with(compact('pormes'))
            ->with(compact('productosmasvendidos'))
            ->with(compact('ventassemanapasada'))
            ->with(compact('ventasporhoras'))
            ->with(compact('graficogrande'));
    }
    public function itbisporproducto(Request $request)
    {
        $iduser = Auth::id();
        $id = $request->id;
        $porciento = DB::connection('client')->select("SELECT products.*, impuestosrefs.descripcion, rangoimpuestos.porciento FROM products, impuestosrefs, rangoimpuestos WHERE products.impuestoref_id = impuestosrefs.id AND rangoimpuestos.referenciaitbis_id = impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta AND products.user_id = ".$iduser." AND products.id =".$id);

        if ($porciento == []){
            $porciento = 0;
        }else{
            $porciento = $porciento;
        }

        return $porciento;
    }
    public function ultimoid()
    {
        $id = Auth::id();

        $ultimoid = Facture::all()->last()->id;

        return $ultimoid;
    }
    public function productospaginado(Request $request)
    {
        $id = Auth::id();
        $productos = DB::connection('client')
            ->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos',
                'rangoimpuestos.referenciaitbis_id',
                DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->select(
                DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion')
            );

        if($request->search)
        {
            $productos = $productos->where('products.name', 'like', '%'.$request->search.'%');
        }

        if($request->filter['category'])
        {
            $productos = $productos->where('products.categoria_id', '=', $request->filter['category']);
        }

        if($request->filter['status'] && $request->filter['status'] != 'all')
        {
            $productos = $productos->where('products.estado', '=', $request->filter['status'] == 1 ? true : false);
        }

        $productos = $productos->paginate($request->paginate ? $request->paginate : 5);

        return $productos;
    }
    public function allproduct()
    {
        $id = Auth::id();
        $productos = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
//            ->where('products.user_id', $id)
            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->get();

        return $productos;
    }

    public function productosSelect(){
        return DB::connection('client')
            ->table('products')
            ->where('estado', true)
            ->select('id','name', 'price', 'barcode')
            ->get();
    }

    public function productosSelectforPurchase(){
        return DB::connection('client')
            ->table('products')
            ->where('estado', true)
            ->where('purchase_config', true)
            ->select('id','name', 'price', 'barcode')
            ->get();
    }

    public function productosSelectforSale(){
        return DB::connection('client')
            ->table('products')
            ->where('estado', true)
            ->where('sale_config', true)
            ->orWhere('service_config', true)
            ->select('id','name', 'price', 'barcode')
            ->get();
    }

}
