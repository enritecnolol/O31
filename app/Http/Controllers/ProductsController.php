<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $productos = DB::table('products')->where('user_id', $id)->paginate(7);
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
                $product->status = 1;
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->save();

            }else{

                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 1;
                $product->img = 'default.jpg';
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
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
                $product->status = 1;
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
                $product->save();

            }else{
                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('barcode');
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 1;
                $product->img = 'default.jpg';
                $product->user_id = Auth::id();
                $product->categoria_id = $request->input('categoria');
                $product->subcategoria_id = $request->input('subcategoria');
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
