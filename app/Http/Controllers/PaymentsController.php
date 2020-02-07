<?php

namespace App\Http\Controllers;

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
                    $payment_item->original_amount = $item['total'];
                    $payment_item->open_balance = $item['open_balance'];
                    $payment_item->pay = $item['amountReceived'];
                    $payment_item->discount = $item['discount'];
                    $payment_item->balance_before_pay = $item['BalanceAfterPay'];
                    $payment_item->payment_id = $payment->id;
                    if($item['open_balance'] == ($item['amountReceived'] + $item['discount']))
                    {
                        $invoice = Invoice::find($item['id']);
                        $invoice->open_balance = 0;
                        $invoice->status = 'COMPLETADO';
                        $invoice->paid_status = 'PAGADO';
                        $invoice->update();
                    }else{
                        $invoice = Invoice::find($item['id']);
                        $invoice->open_balance = $item['open_balance'] - ($item['amountReceived'] + $item['discount']);
                        $invoice->status = 'DEUDA';
                        $invoice->paid_status = 'PAGADO PARCIALMENTE';
                        $invoice->update();
                    }
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
