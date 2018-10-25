<?php

namespace App\Http\Controllers;

use App\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index(){
        return view('reporte.index');
    }



    public function busqueda(Request $r){
        $id = Auth::id();

        $facturas = DB::select("SELECT * FROM `factures` WHERE user_id = ".$id." AND date BETWEEN '".$r->inicio."' AND '".$r->fin."' ORDER BY `id` ASC");
        if ($facturas == '[]'){
            $facturas == 'no resultado';
        }else{
            $facturas = $facturas;
        }
        $total = DB::select("SELECT SUM(total_facture) as total FROM `factures` WHERE user_id = ".$id." AND date BETWEEN '".$r->inicio."' AND '".$r->fin."'");

        return view('reporte.tableCont')->with(compact('facturas'))->with(compact('total'));
    }
}
