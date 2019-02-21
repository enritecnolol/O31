<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreasController extends Controller
{
    public function store(Request $request)
    {
        $area = new Area;
        $area->nombre = $request->nombre;
        $area->user_id = Auth::id();
        $area->save();
        return 'datos guardado';
    }
    public function allareas()
    {
        $areas = Area::all();
        return $areas;
    }
}
