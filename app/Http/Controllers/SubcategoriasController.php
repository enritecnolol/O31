<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Product;
use App\Subcategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoriasController extends Controller
{
    public function crearsubcategoria(Request $request)
    {
        $sub = new Subcategoria;
        $iduser = Auth::id();

        if ($request->hasFile('img')){
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $sub->nombre = $request->nombre;
            $sub->img = $file->getClientOriginalName();
            $sub->categoria_id = $request->idcategoria;
            $sub->user_id = $iduser;
            $sub->save();

        }else{

            $sub->nombre = $request->nombre;
            $sub->img = 'default.jpg';
            $sub->categoria_id = $request->idcategoria;
            $sub->user_id = $iduser;
            $sub->save();

        }
        return redirect('/categorias');
    }

    public function mostrarsubcategorias(Request $request)
    {
        $id = Auth::id();
        $sub = Subcategoria::all()->where('categoria_id', '==', $request->id)->where('user_id', '==', $id);
        return $sub;
    }
    public function editarsubcategoria(Request $request){

        $sub = Subcategoria::find($request->id);
        return $sub;
    }
    public function subcategoriaeditar(Request $request, $id)
    {
        $sub = Subcategoria::where('id', $id)->first();

        $iduser = Auth::id();
        if ($request->hasFile('img')){
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $sub->nombre = $request->nombre;
            $sub->img = $file->getClientOriginalName();
            $sub->categoria_id = $request->idcategoria;
            $sub->user_id = $iduser;
            $sub->update();

        }else{

            $sub->nombre = $request->nombre;
            $sub->categoria_id = $request->idcategoria;
            $sub->user_id = $iduser;
            $sub->update();

        }
        return redirect('/categorias');
    }
    public function productosubcategoria(Request $request){
        $id = Auth::id();
        $sub = Subcategoria::all()->where('categoria_id', '==', $request->id)->where('user_id', $id);
        return $sub;

    }
    public function nuevasubcategoria(Request $request){
        $sub = new Subcategoria;
        $iduser = Auth::id();
        $sub->nombre = $request->nombre;
        $sub->img = 'default.jpg';
        $sub->categoria_id = $request->idcategoria;
        $sub->user_id = $iduser;
        $sub->save();
        return 'bien';
    }
    public function subcategoriavender(Request $request){
        $id = Auth::id();
        $subcategorias = Subcategoria::all()->where('categoria_id', '==', $request->id)->where('user_id', $id);
        return $subcategorias;

    }
    public function subcategoriaproductos(Request $request){
        $id = Auth::id();
        $productos = Product::all()->where('subcategoria_id', '==', $request->id)->where('user_id',$id);
        return $productos;
    }
    public function versubcategorias(){
        $id = Auth::id();
        $sub = Subcategoria::all()->where('user_id', '==', $id);
        return $sub;
    }
    public function eliminardos(Request $request){
        $categoria = Categoria::find($request->id);
        $categoria->delete();

        $subcategoria = Subcategoria::where('categoria_id', $request->id)->delete();
        return 'eliminados';
    }
    public function eliminarsubcategoria(Request $request){
        $sub = Subcategoria::find($request->id);
        $sub->delete();

        return'eliminado';
    }
}
