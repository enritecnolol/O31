<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Invoice;
use App\Payment;
use App\Payment_item;
use App\Payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class PaymentsController extends Controller
{
    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{

            $config = DB::connection('client')->table('configuracions')->first();

            $payment = new Payment();
            $payment->client_id = $request->client_id['code'];
            $payment->date = date("Y-m-d", strtotime($request->date));
            $payment->email = $request->email;
            $payment->payment_method_id = $request->payment_method_id['code'];
            $payment->reference = $request->reference;
            $payment->deposit_to = $request->deposit_to;
            $payment->amount= $request->amount;
            $payment->save();

            foreach ($request->items as $item)
            {
                if($item['amountReceived'] > 0)
                {
                    $payment_item = new Payment_item();
                    $payment_item->invoice_id = $item['id'];
                    $payment_item->original_amount = $item['total_facture'];
                    $payment_item->open_balance = $item['open_balance'];
                    $payment_item->pay = $item['amountReceived'];
                    $payment_item->discount = $item['discount'];
                    $payment_item->balance_before_pay = $item['BalanceAfterPay'];
                    $payment_item->payment_id = $payment->id;

                    $facture = Facture::find($item['id']);
                    $facture->open_balance = $item['open_balance'] - ($item['amountReceived'] + $item['discount']);
                    $facture->status = 'DEUDA';
                    $facture->paid_status = 'PAGADO PARCIALMENTE';

                    if($item['open_balance'] == ($item['amountReceived'] + $item['discount']))
                    {
                        $facture->open_balance = 0;
                        $facture->status = 'COMPLETADO';
                        $facture->paid_status = 'PAGADO';
                    }

                    $facture->update();
                    $payment_item->save();
                }
            }


            if($request->send)
            {
                $dataPDF = [
                    'data' => $request,
                    'company' => $config,
                ];
                $pdf = PDF::loadView('emails.receiptPayment', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L',
                    'orientation' => 'landscape'
                ]);
                $pdf->setPaper('A4', 'landscape');
                $email = $request->email;
                $fecha = date("Y-m-d", strtotime($request->date));
                $dataMail = ['customer' => $request->client_id['label'] ];
                Mail::send('emails.receiptPaymentMail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf, $fecha) {
                    $message->to($email);
                    $message->subject('Recibo de pago '. $fecha );
                    $message->attachData($pdf->output(), "recibo_de_pago_$fecha.pdf");
                });
            }

            DB::connection('client')->commit();
            return 'success';
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function printTest()
    {
        $request=
            [
                "client_id" =>[
                    "label"=> "Tomas De Leon",
                    "code"=> 2
                ],
                "date"=> "2020-02-24T15=>18=>16.046Z",
                "email"=> "enritecnolol@gmail.com",
                "payment_method_id"=> [
                    "label"=> "Cash",
                    "code"=> 3
                ],
                "reference"=> "",
                "deposit_to"=> "",
                "amount"=> 6535,
                "items"=> [[
                    "id"=> 37969,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 15000,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 15000,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 09=>17=>47",
                    "updated_at"=> "2020-02-24 09=>34=>08",
                    "leycamarero"=> null,
                    "due_date"=> "2020-02-29",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 6500,
                    "paid_status"=> "PAGADO PARCIALMENTE",
                    "discount"=> 500,
                    "amountReceived"=> 6000,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ], [
                    "id"=> 37971,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 35,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 35,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 10=>46=>18",
                    "updated_at"=> "2020-02-24 10=>46=>18",
                    "leycamarero"=> null,
                    "due_date"=> "2020-03-10",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 35,
                    "paid_status"=> "NO PAGADO",
                    "discount"=> 0,
                    "amountReceived"=> 35,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ], [
                    "id"=> 37972,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 325,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 325,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 10=>48=>31",
                    "updated_at"=> "2020-02-24 10=>48=>31",
                    "leycamarero"=> null,
                    "due_date"=> "2020-03-10",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 325,
                    "paid_status"=> "NO PAGADO",
                    "discount"=> 0,
                    "amountReceived"=> 0,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ], [
                    "id"=> 37973,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 9750,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 9750,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 10=>51=>20",
                    "updated_at"=> "2020-02-24 10=>51=>20",
                    "leycamarero"=> null,
                    "due_date"=> "2020-03-10",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 9750,
                    "paid_status"=> "NO PAGADO",
                    "discount"=> 0,
                    "amountReceived"=> 0,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ], [
                    "id"=> 37974,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 150,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 150,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 10=>54=>02",
                    "updated_at"=> "2020-02-24 10=>54=>02",
                    "leycamarero"=> null,
                    "due_date"=> "2020-03-10",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 150,
                    "paid_status"=> "NO PAGADO",
                    "discount"=> 0,
                    "amountReceived"=> 0,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ], [
                    "id"=> 37975,
                    "date"=> "2020-02-24",
                    "box"=> null,
                    "cashier"=> 0,
                    "client"=> "2",
                    "brute"=> 90,
                    "desc"=> 0,
                    "itbis"=> 0,
                    "total_facture"=> 90,
                    "Monto_tarjeta"=> null,
                    "Monto_efectivo"=> null,
                    "returns"=> 0,
                    "puntos"=> null,
                    "ticket_id"=> null,
                    "status"=> "DEUDA",
                    "type_sale"=> "personalizado",
                    "type_tarject"=> null,
                    "Numbertar"=> null,
                    "Banco"=> null,
                    "auth"=> null,
                    "tipo_nfc"=> null,
                    "nfc"=> null,
                    "telefono_nfc"=> null,
                    "rnc_nfc"=> null,
                    "razon_nfc"=> null,
                    "caja_id"=> null,
                    "user_id"=> null,
                    "created_at"=> "2020-02-24 11=>17=>39",
                    "updated_at"=> "2020-02-24 11=>17=>39",
                    "leycamarero"=> null,
                    "due_date"=> "2020-03-10",
                    "address"=> "Santiago de los caballeros, Villa olimpica, Manz. F1 Edif. 4D",
                    "note"=> null,
                    "email"=> "enritecnolol@gmail.com",
                    "open_balance"=> 90,
                    "paid_status"=> "NO PAGADO",
                    "discount"=> 0,
                    "amountReceived"=> 0,
                    "BalanceAfterPay"=> 0,
                    "check"=> false
                ]]
            ];
        $config = DB::connection('client')->table('configuracions')->first();


        $dataPDF = [
            'data' => $request,
            'company' => $config,
        ];

        return view('emails.receiptPayment')->with(compact('dataPDF', $dataPDF));
    }
}
