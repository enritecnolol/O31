<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Client;
use App\Detail;
use App\Detallesecuencia;
use App\Estimate;
use App\Facture;
use App\Invoice;
use App\Invoice_item;
use App\Term;
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
        DB::connection('client')->beginTransaction();
        try{
            $idcaja = Caja::all();
            $facture = new Facture();
            $facture->date = date("Y-m-d", strtotime($request->invoice_date));
            $facture->client = $request->client_id['code'];
            $facture->address = $request->address;
            $facture->due_date = date("Y-m-d", strtotime($request->due_date));
            $facture->note = $request->note;
            $facture->email = $request->email;
            $facture->brute = $request->subtotal;
            $facture->desc = $request->discount;
            $facture->itbis = $request->tax;
            $facture->discount_percent = $request->discountPercent;
            $facture->total_facture = $request->total;
            $facture->open_balance = $request->total;
            $facture->type_sale = 'personalizado';
            $facture->status = 'DEUDA';
            $facture->paid_status = 'NO PAGADO';
            $facture->recurring_bill = $request->recurring_bill;
            if($request->recurring_bill)
            {
                $facture->send_recurring_bill = date("Y-m-d", strtotime($request->due_date));
            }
            $term = Term::find($request->term);
            if($term->number_days == 0)
            {
                $facture->open_balance = 0;
                $facture->status = 'COMPLETADO';
                $facture->paid_status = 'PAGADO';
            }
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
            $facture->caja_id = $idcaja->last()->id;
            $facture->term_id = $request->term;
            $facture->user_id = Auth::id();
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
                    'invoice_id' => $facture->id,
                    'term_days' => $term->number_days
                ];
                $pdf = PDF::loadView('emails.invoice', compact( 'dataPDF'))->setPaper('a4');

                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->invoice_date));
                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->invoice_number, 'auth_id' => Auth::id(), 'invoice_id' => $facture->id];
                Mail::send('emails.invoicemail', compact( 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });
            }

            DB::connection('client')->commit();
            return ['message' => 'success', 'notification' => $aviso, 'ncfDueDate' => $NFCDueDate, 'send' => $request->send];
        }catch (\Exception $e)
        {
            DB::connection('client')->rollBack();
            return response()->json($e, 400);
        }

    }
    public function edit(Request $request)
    {
        DB::connection('client')->beginTransaction();

        try {
            $invoicesItemsDBId = array();
            $invoicesItemsDB = DB::connection('client')->table('details')->where('invoice_id', $request->id)->get();
            foreach ($invoicesItemsDB as $invoiceD)
            {
                array_push($invoicesItemsDBId, $invoiceD->id);
            }

            $facture = Facture::find($request->id);
            $facture->date = date("Y-m-d", strtotime($request->invoice_date));
            $facture->due_date = date("Y-m-d", strtotime($request->due_date));
            $facture->client = $request->client_id['code'];
            $facture->address = $request->address;
            $facture->note = $request->note;
            $facture->email = $request->email;
            $facture->brute = $request->subtotal;
            $facture->itbis = $request->tax;
            $facture->desc = $request->discount;
            $facture->discount_percent = $request->discountPercent;
            $facture->total_facture = $request->total;
            $facture->open_balance = $request->total;
            $facture->recurring_bill = $request->recurring_bill;
            $facture->update();

            foreach ($request->details as $detail)
            {
                if(!array_key_exists('id',$detail))
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
                    continue;
                }
                $detalle = Detail::find($detail['id']);

                if(in_array($detail['id'], $invoicesItemsDBId)){
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
                    $detalle->description = $detail['description'];
                    $detalle->amount = $detail['amount'];
                    $detalle->invoice_id = $facture->id;
                    $detalle->update();
                }else{
                    $detalle->delete();
                }

            }

            if($request->send)
            {
                $company = DB::connection('client')->table('configuracions')->first();
                $dataPDF = [
                    'data' => $request,
                    'company' => $company,
                    'fiscal' => ['ncf' => $facture->nfc, 'NFCDueDate' => $facture->due_date, 'config' => $company->generacomprobante],
                    'invoice_id' => $facture->id
                ];
                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->invoice_date));
                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->id, 'auth_id' => Auth::id(), 'invoice_id' => $request->id];
                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });
            }

            DB::connection('client')->commit();

            return 'success';
        }catch (\Exception $e)
        {
            DB::connection('client')->rollBack();
            return $e;
        }
    }

    public function getInvoiceData(Request $request)
    {
        $facture = Facture::find($request->invoice_id);
        $details = DB::connection('client')
            ->table('details')
            ->join('products','products.id','=','details.product_id')
            ->Leftjoin(
                'impuestosrefs',
                'products.impuestoref_id',
                'impuestosrefs.id'
            )
            ->Leftjoin(
                'rangoimpuestos',
                'rangoimpuestos.referenciaitbis_id',
                DB::connection('client')->raw('impuestosrefs.id AND CURDATE() BETWEEN rangoimpuestos.desde AND rangoimpuestos.hasta')
            )
            ->where('invoice_id', $request->invoice_id)
            ->select('details.*',
                DB::connection('client')->raw('IFNULL(impuestosrefs.descripcion, "") AS itbis_description'),
                DB::connection('client')->raw('IFNULL(rangoimpuestos.porciento, 0) AS porciento'),
                'impuestoref_id'
            )
            ->get() ;

        if(count($details) == 0)
        {
            $details = DB::connection('client')
                ->table('details')
                ->where('invoice_id', $request->invoice_id)
                ->get();
        }
        $facture->invoice_details = $details;

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

        $data->orderBy('id', 'desc');

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
        $term = Term::find($facture->term_id);
        $dataPDF = [
            'data' => $facture ,
            'company' => $config,
            'fiscal' => ['ncf' => $facture->nfc, 'NFCDueDate' => $facture->due_date, 'config' => $config->generacomprobante],
            'invoice_id' => $request->invoice_id,
            'term_days' => $term->number_days ? $term->number_days : 0
        ];

        return view('Print.invoice')->with(compact('dataPDF'));
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

    public function duplicateInvoice(Request $request)
    {
        $invoice = Facture::find($request->id);
        $invoiceDetails = Detail::where('facture_id', $request->id)->orWhere('invoice_id', $request->id)->get();

        DB::connection('client')->beginTransaction();

        try{

            $idcaja = Caja::all();
            if($idcaja->last()->status != 'A')
            {
                return response()->json(["message" => "La caja actualmente se encuantra Cerrada"], 400);
            }
            $newInvoice = new Facture();
            $newInvoice->date = $invoice->date;
            $newInvoice->client = $invoice->client;
            $newInvoice->address = $invoice->address;
            $newInvoice->due_date = $invoice->due_date;
            $newInvoice->note = $invoice->note;
            $newInvoice->email = $invoice->email;
            $newInvoice->brute = $invoice->brute;
            $newInvoice->desc = 0;
            $newInvoice->total_facture = $invoice->total_facture;
            $newInvoice->open_balance = $invoice->open_balance;
            $newInvoice->type_sale = $invoice->type_sale;
            $newInvoice->status = $invoice->status;
            $newInvoice->paid_status = $invoice->paid_status;
            $newInvoice->caja_id = $idcaja->last()->id;
            $newInvoice->term_id = $invoice->term_id;
            $newInvoice->user_id = Auth::id();
            $newInvoice->save();


            foreach ($invoiceDetails as $detail)
            {
                $detalle = new Detail();
                $detalle->date = now();
                $detalle->name_product = $detail->name_product;
                $detalle->descuento = $detail->descuento;
                $detalle->quanlity = $detail->quanlity;
                $detalle->price = $detail->price;
                $detalle->depot = $detail->depot;
                $detalle->impost = $detail->impost;
                $detalle->description = $detail->description;
                $detalle->amount = $detail->amount;
                $detalle->invoice_id = $newInvoice->id;
                $detalle->facture_id = $newInvoice->id;
                $detalle->save();
            }

            DB::connection('client')->commit();
            return response()->json(["message" => "La factura fue duplicada correctamente"], 200);

        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function invoiceHistoryIndex()
    {
        return view('invoiceHistory.index');
    }

    public function invoiceHistory(Request $request)
    {
        $invoice = DB::connection('client')
            ->table('factures')
            ->leftJoin('clients', 'factures.client', '=', 'clients.id')
            ->where('factures.id', $request->invoice)
            ->select('factures.*', DB::raw('clients.nombre clientname'))
            ->first();

        $transactions = DB::connection('client')
        ->select("select created_at, 'Devolucion' type, total_devolucion amount, itbis,0 discount
                    from devolucions where factura_id = $request->invoice
                    union all
                    select created_at, 'Recibo de ingreso' type, pay amount, 0 itbis, 0 discount
                    from payment_items where invoice_id = $request->invoice;
                    ");
        return ['invoice' => $invoice, 'transactions' => $transactions];
    }
}
