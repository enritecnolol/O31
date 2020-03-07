<?php

namespace App\Http\Controllers;

use App\purchaseDetail;
use App\purchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    //
    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();

        try{

            $purchase = new purchases();
            $purchase->document_no = $request->document_no;
            $purchase->supplier_id = $request->supplier_id['code'];
            $purchase->invoice_date = date("Y-m-d", strtotime($request->invoice_date));
            $purchase->invoice = $request->invoice;
            $purchase->ncf = $request->ncf;
            $purchase->purchase_order = $request->purchase_order;
            $purchase->term_id = $request->term_id['code'];
            $purchase->note = $request->note;
            $purchase->subtotal = $request->subtotal;
            $purchase->itbis = $request->itbis;
            $purchase->total = $request->total;
            $purchase->status = true;
            $purchase->balance = $request->total;
            $purchase->payment_status = 'NO PAGADO';
            $purchase->kind_purchase = $request->kind_purchase;
            $purchase->save();

            foreach ($request->items as $item)
            {
                $purchaseDetail = new purchaseDetail();
                $purchaseDetail->quantity = $item['quantity'];
                $purchaseDetail->price = $item['price'];
                $purchaseDetail->itbis = $item['itbis'];
                $purchaseDetail->total = $item['total'];
                $purchaseDetail->product_id = $item['product']['code'];
                $purchaseDetail->purchase_id = $purchase->id;
                $purchaseDetail->save();
            }

            DB::connection('client')->commit();
            return response()->json(["message" => "Los datos fueron guardado con exito"], 200);
        }catch (\Exception $e)
        {

            DB::connection('client')->rollback();
            return response()->json($e, 400);

        }
    }

    public function listPaginate($size = 10)
    {
        $query = DB::connection('client')
            ->table('purchases')
            ->paginate($size);

        return $query;
    }
    public function getData(Request $request)
    {
        $purchase = purchases::find($request->id);
        $purchase->details = purchaseDetail::where('purchase_id', $request->id)->get();
        return $purchase;
    }
}
