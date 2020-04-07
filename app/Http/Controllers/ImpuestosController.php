<?php

namespace App\Http\Controllers;

use App\Impuesto;
use App\Impuestosref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpuestosController extends Controller
{
    public function itbis()
    {
        $ref = Impuestosref::all();
        if  (!$ref){
            $ref = 0;
        }

        return view('configuracion.itbis.index2', compact('ref'));
    }
    public function store(Request $request)
    {
        $itbis = new Impuesto();
        $itbis->desde = $request->fechadesde;
        $itbis->hasta = $request->fechahasta;
        $itbis->itbis = $request->itbis;
        $itbis->user_id = Auth::id();
        $itbis->save();
        return 'bien';
    }
    public function datos()
    {
        $id = Auth::id();
        $itbis = Impuesto::all();

        if ($itbis == '[]'){
            $itbis = 'no resultado';
        }

        return $itbis;
    }
    public function editarbuscardatos(Request $request)
    {
        $id = $request->id;
        $itbis = Impuesto::find($id);
        if ($itbis == ''){
            $itbis = 'no resultado';
        }else{
            $itbis = $itbis;
        }
        return $itbis;
    }
    public function editaritbis(Request $request)
    {
        $id = $request->datos['id'];

        $itbis = Impuesto::find($id);
        $itbis->desde = $request->datos['desde'];
        $itbis->hasta = $request->datos['hasta'];
        $itbis->itbis = $request->datos['itbis'];
        $itbis->update();
        return 'editado';
    }
}
