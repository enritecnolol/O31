<?php

namespace App\Http\Controllers;

use App\Tcxp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TcxpsController extends Controller
{
    public function store(Request $request)
    {
        $tcxp = new Tcxp();
        $tcxp->nombre = $request->nombre;
        $tcxp->user_id = Auth::id();
        $tcxp->save();
        return 'guardado';
    }
    public function todosdatos()
    {
        $tcxp = Tcxp::all();
        return $tcxp;
    }
}
