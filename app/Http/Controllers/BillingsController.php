<?php

namespace App\Http\Controllers;

use App\Estimate;
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

        if (count(DB::connection('client')->table('invoices')->where('invoice_number', $request->invoice_number)->get()) != 0)
        {
            return response()->json(['message' => 'El codigo de factura en uso'], 400);
        }

        try{
            $invoice = new Invoice();
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
            $invoice->status = 'DEUDA';
            $invoice->paid_status = 'NO PAGADO';
            $invoice->save();

            foreach ($request->details as $detail)
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
            }

            if($request->send)
            {
                $company = DB::connection('client')->table('configuracions')->first();
                $dataPDF = [
                    'data' => $request,
                    'company' => $company
                ];
                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->invoice_date));
                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->invoice_number, 'auth_id' => Auth::id(), 'invoice_id' => $invoice];
                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });
            }

            DB::commit();

            return 'success';
        }catch (\Exception $e)
        {
            DB::rollBack();
            return $e;
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

            if($request->send)
            {
                $company = DB::connection('client')->table('configuracions')->first();
                $dataPDF = [
                    'data' => $request,
                    'company' => $company
                ];
                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->invoice_date));
                $dataMail = ['customer' => $request->client_id['label'], 'facture' => $request->invoice_number, 'auth_id' => Auth::id(), 'invoice_id' => $invoice];
                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });
            }

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
        $invoice = Invoice::find($request->invoice_id);
        $invoice->invoice_details = DB::connection('client')->table('invoice_items')->where('invoice_id', $request->invoice_id)->get();

        return $invoice;
    }

    public function invoicesList(Request $request)
    {

        $data = DB::connection('client')->table('invoices');

        $filters = json_decode($request['filters'],true);

        if($filters["customer"] != "")
        {
            $data->where('client_id', $filters["customer"]['code']);
        }

        if($filters['codeInvoice'])
        {
            $data->where('invoice_number', $filters['codeInvoice']);
        }

        if($filters['from'] && $filters['to'])
        {
            $data->whereBetween('invoice_date', [
                date("Y-m-d", strtotime($filters['from'])),
                date("Y-m-d", strtotime($filters['to']))
            ]);
        }


        return $data->paginate(10);
    }

    public function PaymentIndex()
    {
        return view('facturacion.pago_factura');
    }

    public function getInvoiceClient(Request $request)
    {
        $invoices = DB::connection('client')
            ->table('invoices')
            ->where('client_id' , (int) $request->client_id)
            ->where('open_balance', '>', 0)
        ;

        return $invoices->get();
    }
}
