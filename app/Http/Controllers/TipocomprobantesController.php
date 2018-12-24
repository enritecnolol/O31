<?php

namespace App\Http\Controllers;

use App\tipocomprobante;
use Illuminate\Http\Request;

class TipocomprobantesController extends Controller
{
    public function store(Request $request)
    {
        $tipocomprobante = new tipocomprobante();
        $tipocomprobante->nombre = $request->nombre;
        $tipocomprobante->save();
         return 'Que miras?';
    }
    public function datostabla ()
    {
        $datos = tipocomprobante::all();
        return $datos;
    }
}