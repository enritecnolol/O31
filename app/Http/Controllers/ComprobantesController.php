<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprobantesController extends Controller
{
    public function index()
    {
        return view('secuenciacomprobante.index');
    }
}
