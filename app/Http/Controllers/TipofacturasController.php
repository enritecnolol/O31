<?php

namespace App\Http\Controllers;

use App\Tipofactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipofacturasController extends Controller
{
    public function store(Request $request)
    {
        $tipofactura = new Tipofactura();
        $tipofactura->nombre = $request->nombre;
        $tipofactura->user_id = Auth::id();
        $tipofactura->save();
        return 'guardado';
    }
    public function datos()
    {
        $tiposfactura = Tipofactura::all()->where('user_id', Auth::id());
        return $tiposfactura;
    }
}
