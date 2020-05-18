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
        $from_date = $request->date[0];
        $end_date = $request->date[1];

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

    public function indexReport608()
    {
        return view('Reporte607.report608');
    }

    public function getDataReport608(Request $request)
    {
        $from_date = $request->date[0];
        $end_date = $request->date[1];

        $data = DB::connection('client')
            ->table(DB::raw('devolucions as d'))
            ->Join('factures', 'factures.id', '=', 'd.factura_id')
            ->whereBetween('d.date', [$from_date, $end_date]);

        if($request->tiponfc)
        {
            $data->where('factures.tipo_nfc', $request->tiponfc);
        }
//        if($request->MaxAmount)
//        {
//            $data->where('tipo_nfc', '02')->where('total_facture', '>=', $request->MaxAmount);
//        }

        $data->select(
            DB::raw('d.*'),
            DB::raw("'01' as tipo_anulacion")
        );
        $size = $request->size;

        return $data->paginate($size);
    }

    public function indexReport606()
    {
        return view('Reporte607.report606');
    }

}
