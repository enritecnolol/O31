<?php

namespace App\Http\Controllers;

use App\Camarero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CamarerosController extends Controller
{
    public function index()
    {
        return view('camarero.index');
    }
    public function store(Request $request)
    {
        $camarero = new Camarero();
        $camarero->codigo = $request->codigo;
        $camarero->nombre = $request->nombre;
        $camarero->telefono = $request->telefono;
        $camarero->cedula = $request->cedula;
        $camarero->user_id = Auth::id();
        $camarero->save();

    }
    public function allcamareros()
    {
        $camarero = Camarero::all()->where('user_id', Auth::id());
        return $camarero;
    }
    public function allcamarerospagination()
    {
        $camarero = Camarero::where('user_id', Auth::id())->paginate(6);
        return $camarero;
    }
    public function edit(Request $request)
    {
        $camarero = Camarero::find($request->id);
        $camarero->codigo = $request->codigo;
        $camarero->nombre = $request->nombre;
        $camarero->telefono = $request->telefono;
        $camarero->cedula = $request->cedula;
        $camarero->update();
    }
    public function delete(Request $request)
    {
        $camarero = Camarero::find($request->id);
        $camarero->delete();
    }
}
