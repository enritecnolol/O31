<?php

namespace App\Http\Controllers;

use App\Facture;
use App\Invoice;
use App\Payment;
use App\Payment_item;
use App\Payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{

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
            DB::commit();
            return 'success';
        }catch (\Exception $e)
        {
            DB::rollback();
            return response()->json($e, 400);
        }
    }
}
