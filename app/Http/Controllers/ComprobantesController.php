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
        DB::connection('client')->beginTransaction();
        try{

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

            $header = new Headersecuencia();
            $header->fechaemision = $request->fecha_emision;
            $header->fechavencimiento = $request->fecha_vecimiento;
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

            DB::connection('client')->commit();
            return 'bien';
        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return $e;
        }

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
        $rnc = DB::connection('client')->select("SELECT factures.telefono_nfc, factures.rnc_nfc, factures.razon_nfc FROM `factures`  WHERE rnc_nfc = ".$request->rnc." LIMIT 1");
        return $rnc;
    }

    public function rnctest(Request $request)
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:dgii="http://dgii.gov.do/">
    <soap:Header/>
    <soap:Body>
        <dgii:GetContribuyentes>
            <dgii:value>'.$request['rnc'].'</dgii:value>
            <dgii:patronBusqueda>0</dgii:patronBusqueda>
            <dgii:inicioFilas>0</dgii:inicioFilas>
            <dgii:filaFilas>1</dgii:filaFilas>
            <dgii:IMEI></dgii:IMEI>
        </dgii:GetContribuyentes>
    </soap:Body>
</soap:Envelope>';

        $url = 'http://dgii.gov.do/wsMovilDGII/WSMovilDGII.asmx';
        $curl = curl_init($url);
        //Set the Content-Type to text/xml.
        curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        //Set CURLOPT_POST to true to send a POST request.
        curl_setopt($curl, CURLOPT_POST, 1);
        //Attach the XML string to the body of our request.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
        //Tell cURL that we want the response to be returned as
        //a string instead of being dumped to the output.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
        curl_setopt($curl, CURLOPT_MAXREDIRS,5);
        //Execute the POST request and send our XML.
        $result = curl_exec($curl);
        //Do some basic error checking.
        if(curl_errno($curl)){
            throw new \Exception (curl_error($curl));
        }
        curl_close($curl);
        return $result ;
    }
}
