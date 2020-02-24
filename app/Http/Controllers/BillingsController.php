<?php

namespace App\Http\Controllers;

use App\Client;
use App\Detail;
use App\Detallesecuencia;
use App\Estimate;
use App\Facture;
use App\Invoice;
use App\Invoice_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class BillingsController extends Controller
{
    //
    public function index()
    {
        return view('facturacion.index');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $facture = new Facture();
            $facture->date = date("Y-m-d", strtotime($request->invoice_date));
            $facture->client = $request->client_id['code'];
            $facture->address = $request->address;
            $facture->due_date = date("Y-m-d", strtotime($request->due_date));
            $facture->note = $request->note;
            $facture->email = $request->email;
            $facture->brute = $request->subtotal;
            $facture->desc = 0;
            $facture->total_facture = $request->total;
            $facture->open_balance = $request->total;
            $facture->type_sale = 'personalizado';
            $facture->status = 'DEUDA';
            $facture->paid_status = 'NO PAGADO';
            $nfc = '';
            $aviso = '';
            $NFCDueDate = '';
            $config = DB::connection('client')->table('configuracions')->first();
            if ($config->generacomprobante == 'si'){
                $facture->tipo_nfc = $request->tiponfc;

                $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");

                foreach ($headers as $header)
                {
                    $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc',$request->tiponfc);
                    foreach ($details as $detail)
                    {
                        if (($detail->actual + $detail->aviso) >= $detail->secuencia_final){
                            $aviso = "En la Solicitud #". $header->id. " Serie: ". $detail->serie. ", Tipo de NCF: ".$request->tiponfc . " Se estan agotando";
                        }
                        if ($detail->actual < $detail->secuencia_final)
                        {
                            $NFCDueDate = $header->fechavencimiento;
                            $nfc = $detail->serie."".$detail->tipo_nfc."".str_pad($detail->actual,8,"0",STR_PAD_LEFT);
                            $d = Detallesecuencia::find($detail->id);
                            $d->actual = $detail->actual+1;
                            $d->update();
                            break;
                        }
                    }
                }
                if ($nfc == '')
                {
                    return 'No es posible hacer la factura por falta de Comprobantes';
                }
                $facture->nfc = $nfc;
                if ($request->tiponfc != '02')
                {
                    $facture->telefono_nfc = $request->datancf['telefono'];
                    $facture->rnc_nfc = $request->datancf['rnc'];
                    $facture->razon_nfc = $request->datancf['razon'];
                }
            }

            $facture->save();

            foreach ($request->details as $detail)
            {
                $detalle = new Detail();
                $detalle->date = now();
                if($detail['product']['label'])
                {
                    $detalle->name_product = $detail['product']['label'];

                    if(isset($detail['product']['code']))
                    {
                        $detalle->product_id = $detail['product']['code'];
                    }
                }
                $detalle->descuento = $detail['discount'];
                $detalle->quanlity = $detail['quantity'];
                $detalle->price = $detail['price'];
                $detalle->depot = 0;
                $detalle->impost = 0;
                $detalle->description = $detail['description'];
                $detalle->amount = $detail['amount'];
                $detalle->invoice_id = $facture->id;
                $detalle->save();
            }


            if($request->send)
            {
                $dataPDF = [
                    'data' => $request,
                    'company' => $config,
                    'fiscal' => ['ncf' => $nfc, 'NFCDueDate' => $NFCDueDate, 'config' => $config->generacomprobante],
                    'invoice_id' => $facture->id
                ];
                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'))->setPaper('a4', 'landscape');

                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->invoice_date));
                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->invoice_number, 'auth_id' => Auth::id(), 'invoice_id' => $facture->id];
                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });
            }

            DB::commit();
            return ['message' => 'success', 'notification' => $aviso, 'ncfDueDate' => $NFCDueDate, 'send' => $request->send];
        }catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json($e, 400);
        }

    }
    public function edit(Request $request)
    {
        DB::beginTransaction();

        try {
            $invoicesItemsDBId = array();
            $invoicesItemsDB = DB::connection('client')->table('invoice_items')->where('invoice_id', $request->id)->get();
            foreach ($invoicesItemsDB as $invoiceD)
            {
                array_push($invoicesItemsDBId, $invoiceD->id);
            }

            $invoice = Invoice::find($request->id);
            $invoice->invoice_number= $request->invoice_number;
            $invoice->invoice_date = date("Y-m-d", strtotime($request->invoice_date));
            $invoice->due_date = date("Y-m-d", strtotime($request->due_date));
            $invoice->client_id = $request->client_id['code'];
            $invoice->address = $request->address;
            $invoice->note = $request->note;
            $invoice->email = $request->email;
            $invoice->subtotal = $request->subtotal;
            $invoice->total = $request->total;
            $invoice->open_balance = $request->total;
            $invoice->update();

            foreach ($request->details as $detail)
            {
                if(!array_key_exists('id',$detail))
                {
                    $invoice_item = new Invoice_item();
                    if($detail['product']['label'])
                    {
                        $invoice_item->product = $detail['product']['label'];

                        if(isset($detail['product']['code']))
                        {
                            $invoice_item->product_id = $detail['product']['code'];
                        }
                    }
                    $invoice_item->description = $detail['description'];
                    $invoice_item->quantity = $detail['quantity'];
                    $invoice_item->price = $detail['price'];
                    $invoice_item->discount = $detail['discount'];
                    $invoice_item->amount = $detail['amount'];
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->save();
                    continue;
                }
                $invoice_item = Invoice_item::find($detail['id']);
                if(in_array($detail['id'], $invoicesItemsDBId)){

                    if($detail['product']['label'])
                    {
                        $invoice_item->product = $detail['product']['label'];

                        if(isset($detail['product']['code']))
                        {
                            $invoice_item->product_id = $detail['product']['code'];
                        }
                    }
                    $invoice_item->description = $detail['description'];
                    $invoice_item->quantity = $detail['quantity'];
                    $invoice_item->price = $detail['price'];
                    $invoice_item->discount = $detail['discount'];
                    $invoice_item->amount = $detail['amount'];
                    $invoice_item->invoice_id = $invoice->id;
                    $invoice_item->update();
                }else{
                    $invoice_item->delete();
                }

            }

//            if($request->send)
//            {
//                $company = DB::connection('client')->table('configuracions')->first();
//                $dataPDF = [
//                    'data' => $request,
//                    'company' => $company
//                ];
//                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'), [], [
//                    'format' => 'A4-L'
//                ]);
//                $email = $request->email;
//                $fecha = date("Y-m-d", strtotime($request->invoice_date));
//                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->invoice_number, 'auth_id' => Auth::id(), 'invoice_id' => $invoice];
//                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
//                    $message->to($email);
//                    $message->subject('Factura '. $fecha );
//                    $message->attachData($pdf->output(), 'fecha.pdf');
//                });
//            }

            DB::commit();

            return 'success';
        }catch (\Exception $e)
        {
            DB::rollBack();
            return $e;
        }
    }

    public function getInvoiceData(Request $request)
    {
        $facture = Facture::find($request->invoice_id);
        $facture->invoice_details = DB::connection('client')->table('details')->where('invoice_id', $request->invoice_id)->get();

        return $facture;
    }

    public function invoicesList(Request $request)
    {

        $data = DB::connection('client')->table('factures');

        $filters = json_decode($request['filters'],true);

        if($filters["customer"] != "")
        {
            $data->where('client', $filters["customer"]['code']);
        }

        if($filters['codeInvoice'])
        {
            $data->where('id', $filters['codeInvoice']);
        }

        if($filters['status'] != "ALL")
        {
            $data->where('status', $filters['status']);
        }

        if($filters['from'] && $filters['to'])
        {
            $data->whereBetween('date', [
                date("Y-m-d", strtotime($filters['from'])),
                date("Y-m-d", strtotime($filters['to']))
            ]);
        }

        $data->where('type_sale','personalizado')->orderBy('id', 'desc');

        return $data->paginate(10);
    }

    public function PaymentIndex()
    {
        return view('facturacion.pago_factura');
    }

    public function getInvoiceClient(Request $request)
    {
        $invoices = DB::connection('client')
            ->table('factures')
            ->where('client' , (int) $request->client_id)
            ->where('open_balance', '>', 0)
        ;

        return $invoices->get();
    }

    public function printInvoice(Request $request)
    {
        $config = DB::connection('client')->table('configuracions')->first();
        $facture = Facture::find($request->invoice_id);
        $facture->details = json_decode(DB::connection('client')->table('details')->where('invoice_id', $request->invoice_id)->get(), true);
        $client = Client::find($facture->client);
        $facture->client_name = $client->nombre;

        $dataPDF = [
            'data' => $facture ,
            'company' => $config,
            'fiscal' => ['ncf' => $facture->nfc, 'NFCDueDate' => $facture->due_date, 'config' => $config->generacomprobante],
            'invoice_id' => $request->invoice_id
        ];
        return view('Print.invoice')->with(compact('dataPDF', $dataPDF));
    }
    public function ResentInvoice(Request $request)
    {
        $config = DB::connection('client')->table('configuracions')->first();
        $facture = Facture::find($request->invoice_id);
        $facture->details = json_decode(DB::connection('client')->table('details')->where('invoice_id', $request->invoice_id)->get(), true);
        $client = Client::find($facture->client);
        $facture->client_name = $client->nombre;
        $email = $client->email;

        $dataPDF = [
            'data' => $facture ,
            'company' => $config,
            'fiscal' => ['ncf' => $facture->nfc, 'NFCDueDate' => $facture->due_date, 'config' => $config->generacomprobante],
            'invoice_id' => $request->invoice_id
        ];

        $pdf = PDF::loadView('Print.invoice', compact($dataPDF, 'dataPDF'), [], [
            'format' => 'A4-L'
        ]);

        $fecha = date("Y-m-d", strtotime($facture->date));
        $dataMail = ['customer' => $facture->client_name , 'facture' => $request->invoice_id, 'auth_id' => Auth::id(), 'invoice_id' => $request->invoice_id];
        Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
            $message->to($email);
            $message->subject('Factura '. $fecha );
            $message->attachData($pdf->output(), 'fecha.pdf');
        });

    }
    public function lastsInvoices()
    {
        $db = DB::connection('client');

        $query = $db->table('factures')->orderBy('id', 'desc')->limit(9);

        return $query->get();
    }
}
