<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    public function index(){
        $id = Auth::id();
//        $categorias = Categoria::all()->where('user_id', '==', $id)->pagination(5);
        $categorias = DB::connection('client')->table('categorias')->paginate(5);
        return view('categoria.index2', compact('categorias'));
    }



    public function nuevacategoria(Request $request){
        $categoria = new Categoria;

        $request->validate([
            'codigo' => 'required|unique:categorias|max:255',
        ]);

        if ($request->hasFile('img')){
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $categoria->nombre = $request->categoria;
            $categoria->codigo = $request->codigo;
            $categoria->img = $file->getClientOriginalName();
            $categoria->user_id = Auth::id();
            $categoria->save();
        }else{
            $categoria->nombre = $request->categoria;
            $categoria->codigo = $request->codigo;
            $categoria->img = 'default.jpg';
            $categoria->user_id = Auth::id();
            $categoria->save();
        }

        return redirect('categorias');

    }
    public function editarcategoria(Request $request){
        $id = $request->idcategoria;
        $categoria = Categoria::find($id);

        if ($request->hasFile('img')){
            $file = $request->file('img');
            $file->storeAs('/', $file->getClientOriginalName());
            $categoria->nombre = $request->categoria;
            $categoria->codigo = $request->codigo;
            $categoria->img = $file->getClientOriginalName();
            $categoria->update();

        }else{
            $categoria->nombre = $request->categoria;
            $categoria->codigo = $request->codigo;
            $categoria->update();
        }


        return redirect('categorias');

    }
    public function buscarcategoria($id){

        $categoria = Categoria::find($id);

        return $categoria;

    }
    public function allcategories()
    {
        $categorias = Categoria::all();
        return $categorias;
    }
}
