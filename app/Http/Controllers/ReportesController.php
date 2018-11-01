<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Facture;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function index(){
        $id = Auth::id();
        $productos = Product::all()->where('user_id', $id);
        return view('reporte.index')->with(compact('productos'));
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

    public function reporteporproductos($start, $end)
    {
        $id = Auth::id();
        $facturasinicio = DB::select("SELECT * FROM factures WHERE user_id = ".$id." AND date BETWEEN '".$start."' AND '".$end."' ORDER BY `id` ASC");
        $total = DB::select("SELECT SUM(total_facture) as total FROM factures WHERE user_id = ".$id." AND date BETWEEN '".$start."' AND '".$end."'");
        return view('reporte.bodyperiodofacture')->with(compact('facturasinicio'))->with(compact('total'));

    }
    public function reporteproducto($start, $end, Request $request)
    {
        $id = Auth::id();
        $productos = DB::select("SELECT products.name, COUNT(details.product_id) as cantidad, products.impost FROM details, products WHERE products.id = ".$request->producto." AND products.id = details.product_id AND date BETWEEN '".$start."' AND '".$end."' GROUP BY products.name, products.impost");
        return view('reporte.bodyproducto')->with(compact('productos'));
    }
    public function inicio()
    {
        $id = Auth::id();
        $facturasinicio = Facture::all()->where('user_id',$id);
        return view('reporte.bodytableinicio')->with(compact('facturasinicio'));
    }
    public function imprimirventas($start, $end)
    {
        $id = Auth::id();
        $facturasinicio = DB::select("SELECT * FROM factures WHERE user_id = ".$id." AND date BETWEEN '".$start."' AND '".$end."' ORDER BY `id` ASC");
        $total = DB::select("SELECT SUM(factures.brute) as bruto, SUM(factures.desc) AS descuento,  SUM(factures.itbis) AS itbis, SUM(total_facture) as total, SUM(factures.Monto_efectivo) - SUM(factures.returns) AS efectivo, SUM(factures.Monto_tarjeta) AS tarjeta FROM factures WHERE user_id = ".$id." AND date BETWEEN '".$start."' AND '".$end."'");
        $empresa = Configuracion::all()->where('user_id',$id);
        return view('reporte.tableprintventas')
            ->with(compact('facturasinicio'))
            ->with(compact('total'))
            ->with(compact('empresa'))
            ->with(compact('start'))
            ->with(compact('end'));

    }
    public function imprimirreporteproducto($start, $end, Request $request)
    {
        $id = Auth::id();
        $empresa = Configuracion::all()->where('user_id',$id);
        $productos = DB::select("SELECT products.name, COUNT(details.product_id) as cantidad, products.impost FROM details, products WHERE products.id = ".$request->producto." AND products.id = details.product_id AND date BETWEEN '".$start."' AND '".$end."' GROUP BY products.name, products.impost");
        return view('reporte.tablereporteproducto')
            ->with(compact('productos'))
            ->with(compact('start'))
            ->with(compact('end'))
            ->with(compact('empresa'));
    }
}
