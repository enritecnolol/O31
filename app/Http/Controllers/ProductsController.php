<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Product::all();
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
//        $validatedData = $request->validate([
//            'nombre' => 'required|unique:posts|max:255',
//            'precio' => 'required',
//        ]);
        $product = new Product;
        if ($request->has('Cbarra') and $request->has('existencia') and $request->has('impuesto')){

            if ($request->hasFile('img')){
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());
                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('Cbarra');
                $product->img = $file->getClientOriginalName();;
                $product->existence = $request->input('existencia');
                $product->impost = $request->input('impuesto');
                $product->status = 1;
                $product->save();

            }else{

                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = $request->input('Cbarra');
                $product->existence = $request->input('existencia');
                $product->impost = $request->input('impuesto');
                $product->status = 1;
                $product->img = 'default.jpg';
//            $product->unity_id = 0;
                $product->save();

            }

        }else{
            if ($request->hasFile('img')){
                $file = $request->file('img');
                $file->storeAs('/', $file->getClientOriginalName());

                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = '';
                $product->img = $file->getClientOriginalName();
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 1;
//            $product->unity_id = 1;
                $product->save();

            }else{
                $product->name = $request->input('nombre');
                $product->price = $request->input('precio');
                $product->barcode = '';
                $product->existence = 0;
                $product->impost = 0;
                $product->status = 1;
                $product->img = 'default.jpg';
//            $product->unity_id = 0;
                $product->save();

            }

        }



        return redirect('/productos');


    }

    public function show($id)
    {
        $producto = Product::find($id);
        return $producto;
    }

}
