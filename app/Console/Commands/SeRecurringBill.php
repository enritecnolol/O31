<?php

namespace App\Console\Commands;

use App\Caja;
use App\Detail;
use App\Facture;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SeRecurringBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring:bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisar todas las facturas recurrentes para enviar factura al cliente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $recurringBills = DB::connection('client')
            ->table('factures')
            ->where('recurring_bill', 1)
            ->where('send_recurring_bill', DB::raw('CURDATE()'))
            ->get();

        $config = DB::connection('client')->table('configuracions')->first();

        foreach ($recurringBills as $recurringBill)
        {
            $client = DB::connection('client')
            ->table('clients')
            ->where('id', $recurringBill->client)->get();

            if($client->email)
            {
                $recurringBill['details'] = json_decode(DB::connection('client')->table('details')->where('invoice_id', $recurringBill->id)->get(), true);
                $dataPDF = [
                    'data' => $recurringBill,
                    'company' => $config,
                    'fiscal' => ['ncf' => $recurringBill->nfc, 'NFCDueDate' => $recurringBill->due_date, 'config' => $config->generacomprobante],
                    'invoice_id' => $recurringBill->id
                ];
                $pdf = PDF::loadView('emails.invoice', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $client->email;
                $fecha = date("Y-m-d", strtotime($recurringBill->date));
                $dataMail = [
                    'customer' => $client->nombre,
                    'facture' => $recurringBill->id,
                    'auth_id' => Auth::id(),
                    'invoice_id' => $recurringBill->id
                ];
                Mail::send('emails.invoicemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Factura '. $fecha );
                    $message->attachData($pdf->output(), 'fecha.pdf');
                });

                $facture = Facture::find($recurringBill->id);
                $facture->send_recurring_bill = date("Y-m-d", strtotime("+1 month", $facture->send_recurring_bill));
                $facture->update();

                $invoiceDetails = Detail::where('facture_id', $recurringBill->id)->orWhere('invoice_id', $recurringBill->id)->get();
                $idcaja = Caja::all();
                $newInvoice = new Facture();
                $newInvoice->date = date("Y-m-d");
                $newInvoice->client = $facture->client;
                $newInvoice->address = $facture->address;
                $newInvoice->due_date = $facture->due_date;
                $newInvoice->note = $facture->note;
                $newInvoice->email = $facture->email;
                $newInvoice->brute = $facture->brute;
                $newInvoice->desc = $facture->desc;
                $newInvoice->total_facture = $facture->total_facture;
                $newInvoice->open_balance = $facture->open_balance;
                $newInvoice->type_sale = $facture->type_sale;
                $newInvoice->status = $facture->status;
                $newInvoice->paid_status = $facture->paid_status;
                $newInvoice->caja_id = $idcaja->last()->id;
                $newInvoice->term_id = $facture->term_id;
                $newInvoice->user_id = Auth::id();
                $newInvoice->recurring_bill = 0;
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
            }
        }
    }
}
