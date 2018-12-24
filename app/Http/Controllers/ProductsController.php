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
//        $productos = Product::all()->where('user_id', '==', $id);

//        SELECT products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento , IFNULL(impuestosrefs.descripcion, '') AS descripcion FROM products
//        LEFT JOIN impuestosrefs ON products.impuestoref_id = impuestosrefs.id
//        LEFT JOIN rangoimpuestos ON rangoimpuestos.referenciaitbis_id = impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta

        $productos = DB::table('products')
            ->Leftjoin('impuestosrefs', 'products.impuestoref_id', 'impuestosrefs.id')
            ->Leftjoin('rangoimpuestos', 'rangoimpuestos.referenciaitbis_id', DB::raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta'))
            ->where('products.user_id', $id)
            ->select(DB::raw('products.*, IFNULL(rangoimpuestos.porciento, 0) AS porciento, IFNULL(impuestosrefs.descripcion, "") AS descripcion'))->paginate(8);

        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;

        $request->validate([
            'barcode' => 'bail|required|unique:products|max:255',
        ]);

        if ($request->has('refimpuestoid') != 0){
            $itbis = 'si';
        }else{
            $itbis = 'no';
        }
//SELECT products.*, impuestosrefs.descripcion, rangoimpuestos.porciento FROM products, impuestosrefs, rangoimpuestos WHERE products.impuestoref_id = impuestosrefs.id AND rangoimpuestos.referenciaitbis_id = impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta AND products.user_id = 1 AND products.id = 20

        if ($request->has('Cbarra') or $request->has('existencia') or $request->has('impuesto')){

            if ($request->hasFile('img')){
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());
                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->img = $file->getClientOriginalName();
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 0;
                $product->impuestoref_id = $request->input('refimpuestoid');
                $product->itbis = $itbis;
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->compuesto = $request->input('compuesto');
                $product->save();

            }else{

                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 0;
                $product->impuestoref_id = $request->input('refimpuestoid');
                $product->itbis = $itbis;
                $product->img = 'plate.png';
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->compuesto = $request->input('compuesto');
//            $product->unity_id = 0;
                $product->save();

            }

        }else{
            if ($request->hasFile('img')){
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());

                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->img = $file->getClientOriginalName();
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 0;
                $product->impuestoref_id = $request->input('refimpuestoid');
                $product->itbis = $itbis;
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->compuesto = $request->input('compuesto');
                $product->save();

            }else{
                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 0;
                $product->impuestoref_id = $request->input('refimpuestoid');
                $product->itbis = $itbis;
                $product->img = 'plate.png';
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->compuesto = $request->input('compuesto');
                $product->save();

            }

        }



        return redirect('/productos');


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
