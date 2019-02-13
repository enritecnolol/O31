<?php

namespace App\Http\Controllers;

use App\Detallesecuencia;
use App\Headersecuencia;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComprobantesController extends Controller
{
    public function index()
    {
        return view('secuenciacomprobante.index');
    }
    public function store(Request $request)
    {
        if ($request->id != 0)
        {
            foreach ($request->details as $detail)
            {
                $detalle = new Detallesecuencia();
                $detalle->serie = $detail['serie'];
                $detalle->tipo_nfc = $detail['tipo_nfc'];
                $detalle->secuencia_inicial = $detail['secuencia_inicial'];
                $detalle->secuencia_final = $detail['secuencia_final'];
                $detalle->actual = $detail['actual'];
                $detalle->aviso = $detail['aviso'];
                $detalle->header_secuencia_id = $request->id;
                $detalle->user_id = Auth::id();
                $detalle->save();
            }
            return;
        }

        $dateemision = new DateTime($request->fecha_emision);
        $datevencimiento = new DateTime($request->fecha_vencimiento);
        $header = new Headersecuencia();
        $header->fechaemision = $dateemision->format('Y-m-d');
        $header->fechavencimiento = $datevencimiento->format('Y-m-d');
        $header->user_id = Auth::id();
        $header->save();

        $lastheader = Headersecuencia::all();

        foreach ($request->details as $detail)
        {
            $detalle = new Detallesecuencia();
            $detalle->serie = $detail['serie'];
            $detalle->tipo_nfc = $detail['tipo_nfc'];
            $detalle->secuencia_inicial = $detail['secuencia_inicial'];
            $detalle->secuencia_final = $detail['secuencia_final'];
            $detalle->actual = $detail['actual'];
            $detalle->aviso = $detail['aviso'];
            $detalle->header_secuencia_id = $lastheader->last()->id;
            $detalle->user_id = Auth::id();
            $detalle->save();
        }
        return 'bien';
    }
    public function allheader()
    {
        $headers = Headersecuencia::all();
        return $headers;
    }
    public function findheader(Request $request)
    {
        $details = Detallesecuencia::all()->where('header_secuencia_id', $request->id);
        return $details;
    }
    public function editdetail(Request $request)
    {
        $detail = Detallesecuencia::find($request->detail['id']);
        $detail->serie = $request->detail['serie'];
        $detail->tipo_nfc = $request->detail['tipo_nfc'];
        $detail->secuencia_inicial = $request->detail['secuencia_inicial'];
        $detail->secuencia_final = $request->detail['secuencia_final'];
        $detail->actual = $request->detail['actual'];
        $detail->aviso = $request->detail['aviso'];
        $detail->update();

        return 'update';
    }
    public function datarnc(Request $request)
    {
        $rnc = DB::select("SELECT factures.telefono_nfc, factures.rnc_nfc, factures.razon_nfc FROM `factures`  WHERE rnc_nfc = ".$request->rnc." and user_id = ".Auth::id()." LIMIT 1");
        return $rnc;
    }
}
