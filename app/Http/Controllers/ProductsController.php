<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();

        $productos = DB::connection('client')->table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->select(DB::connection('client')->raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->paginate(8);

        return view('productos.index', compact('productos'));
    }

    public function index2()
    {
        return view('products.index');
    }

    public function TestIMG(Request $request)
    {
        if ($request->hasFile('file')) {
            return 'Tiene img';
        }
        return 'no tiene';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function store(Request $request)
    {
        $product = new Product;
        DB::connection('client')->beginTransaction();

        try {

            if(DB::connection('client')->table('products')->where('barcode', $request->input('barcode'))->first())
            {
                return response()->json(['message' => "Este codigo de barra no esta disponible"], 400);
            }

            if ($request->has('refimpuestoid') != 0){
                $itbis = 'si';
            }else{
                $itbis = 'no';
            }

            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());
            }
            $product->name = $request->input('nombre');
            $product->price = $request->input('precio');
            $product->barcode = $request->input('barcode');
            $product->img = $request->hasFile('img') ? $file->getClientOriginalName() : 'default.jpg';
            $product->existence = 0;
            $product->impost = 0;
            $product->status = 0;
            $product->impuestoref_id = $request->input('refimpuestoid');
            $product->itbis = $itbis;
            $product->user_id = Auth::id();
            $product->categoria_id = $request->input('categoria');
            $product->subcategoria_id = $request->input('subcategoria');
            $product->compuesto = $request->input('compuesto');
            $product->sale_config = $request->input('saleConfig');
            $product->service_config = $request->input('serviceConfig');
            $product->inventory_config = $request->input('inventoryConfig');
            $product->purchase_config = $request->input('purchaseConfig');
            $product->save();

            DB::connection('client')->commit();
            return response()->json(['message' => "EL producto fue ingresado con exito"], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
            }
    public function update(Request $request){

        if ($request->hasFile('img')){
            return 'hay';
        }else{
            return 'no hay';
        }


    }


    public function show($id)
    {
        $producto = Product::find($id);
        return $producto;
    }

}
