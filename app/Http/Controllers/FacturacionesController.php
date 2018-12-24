<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturacionesController extends Controller
{
    public function index()
    {
        return view('facturacion.index');
    }
}
