<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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
}
