<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Reporteria607Controller extends Controller
{
    public function index()
    {
        return view('Reporte607.index');
    }
    public function getData(Request $request)
    {
        $from_date = date("Y-m-d",strtotime($request->date."-1"));
        $end_date = date("Y-m-t", strtotime($from_date));

        $data = DB::connection('client')
            ->table(DB::raw('factures as f'))
            ->whereNotNull('f.tipo_nfc')
            ->whereBetween('f.date', [$from_date, $end_date])
            ->leftJoin('devolucions', 'f.id', '=', 'devolucions.factura_id');

        if($request->tiponfc)
        {
            $data->where('tipo_nfc', $request->tiponfc);
        }
//        if($request->MaxAmount)
//        {
//            $data->where('tipo_nfc', '02')->where('total_facture', '>=', $request->MaxAmount);
//        }

        $data->select(
            DB::raw('f.*'),
            DB::raw('devolucions.ncf as ncfdevolucion')
        );
        $size = $request->size;

        return $data->paginate($size);
    }
}
