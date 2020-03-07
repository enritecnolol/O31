<?php

namespace App\Http\Controllers;

use App\purchaseOrder;
use App\purchaseOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class purchaseOrdersController extends Controller
{
    //
    public function index()
    {
        return view('purchaseOrders.index');
    }

    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{

            $purchaseOrder = new purchaseOrder();
            $purchaseOrder->document_no = $request->document_no;
            $purchaseOrder->supplier_id = $request->supplier_id;
            $purchaseOrder->invoice = $request->invoice;
            $purchaseOrder->ncf = $request->ncf;
            $purchaseOrder->purchase_order = $request->purchase_order;
            $purchaseOrder->term_id = $request->term_id;
            $purchaseOrder->note = $request->note;
            $purchaseOrder->save();

            foreach ($request->items as $item)
            {
                $purchaseOrderDetail = new purchaseOrderDetail();
                $purchaseOrderDetail->quantity = $item->quantity;
                $purchaseOrderDetail->price = $item->price;
                $purchaseOrderDetail->itbis = $item->itbis;
                $purchaseOrderDetail->total = $item->total;
                $purchaseOrderDetail->product_id = $item->product_id;
                $purchaseOrderDetail->purchase_order_id = $purchaseOrder->id;
                $purchaseOrderDetail->save();
            }

            DB::connection('client')->commit();
            return response()->json(["message" => "Los datos fueron guardado con exito"], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }
}
