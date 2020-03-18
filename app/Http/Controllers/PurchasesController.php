<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Product;
use App\purchaseDetail;
use App\PurchasePayment;
use App\purchases;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchasesController extends Controller
{
    //
    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();
        $caja = Caja::all()->last();
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
            if($request->kind_purchase == "cash")
            {
                $purchase->balance = 0;
                $purchase->payment_status = 'COMPLETADO';
            }
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

                $product = Product::find($item['product']['code']);
                $product->existence = $product->existence + $item['quantity'];
                $product->update();
            }

            if($request->kind_purchase == "cash") {

                $purchasePayment = new PurchasePayment();
                $purchasePayment->date_payment = date("Y-m-d", strtotime($request->invoice_date));
                $purchasePayment->amount = $request->total;
                $purchasePayment->payment_method = 'Efectivo';
                $purchasePayment->purchase_id = $purchase->id;
                $purchasePayment->caja_id = $caja->id;
                $purchasePayment->save();

            }

            DB::connection('client')->commit();
            return response()->json(["message" => "Los datos fueron guardado con exito"], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function edit(Request $request)
    {
//        DB::connection('client')->beginTransaction();
//
//        try{
//
//            $purchase = new purchases();
//            $purchase->document_no = $request->document_no;
//            $purchase->supplier_id = $request->supplier_id['code'];
//            $purchase->invoice_date = date("Y-m-d", strtotime($request->invoice_date));
//            $purchase->invoice = $request->invoice;
//            $purchase->ncf = $request->ncf;
//            $purchase->purchase_order = $request->purchase_order;
//            $purchase->term_id = $request->term_id['code'];
//            $purchase->note = $request->note;
//            $purchase->subtotal = $request->subtotal;
//            $purchase->itbis = $request->itbis;
//            $purchase->total = $request->total;
//            $purchase->status = true;
//            $purchase->balance = $request->total;
//            $purchase->payment_status = 'NO PAGADO';
//            $purchase->kind_purchase = $request->kind_purchase;
//            if($request->kind_purchase == "cash")
//            {
//                $purchase->balance = 0;
//                $purchase->payment_status = 'PAGADO';
//            }
//            $purchase->save();
//
//            foreach ($request->items as $item)
//            {
//                $purchaseDetail = new purchaseDetail();
//                $purchaseDetail->quantity = $item['quantity'];
//                $purchaseDetail->price = $item['price'];
//                $purchaseDetail->itbis = $item['itbis'];
//                $purchaseDetail->total = $item['total'];
//                $purchaseDetail->product_id = $item['product']['code'];
//                $purchaseDetail->purchase_id = $purchase->id;
//                $purchaseDetail->save();
//
//                $product = Product::find($item['product']['code']);
//                $product->existence = $product->existence + $item['quantity'];
//                $product->update();
//            }
//
//            DB::connection('client')->commit();
//            return response()->json(["message" => "Los datos fueron guardado con exito"], 200);
//        }catch (\Exception $e)
//        {
//            DB::connection('client')->rollback();
//            return response()->json($e, 400);
//        }
    }

    public function listPaginate($size = 10)
    {
        $query = DB::connection('client')
            ->table('purchases')
            ->orderBy('id', 'desc')
            ->paginate($size);

        return $query;
    }
    public function getData(Request $request)
    {
        $purchase = purchases::find($request->id);
        $purchase->details = purchaseDetail::where('purchase_id', $request->id)->get();
        return $purchase;
    }
    public function purchasePaymentIndex ()
    {
        return view('purchasePayment.index');
    }

    public function purchasePaymentData(Request $request)
    {
        $purchase = purchases::find($request->purchase);
        $purchase->details = purchaseDetail::where('purchase_id', $request->purchase)->get();
        $purchase->payments = PurchasePayment::where('purchase_id', $request->purchase)->get();
        return $purchase;
    }

    public function purchasePaymentStore(Request $request)
    {
        DB::connection('client')->beginTransaction();

        try{

            $caja = Caja::all()->last();

            if(!$caja)
            {
                return response()->json(["message" => "No posse caja aperturada"], 400);
            }

            $purchasePayment = new PurchasePayment();
            $purchasePayment->date_payment = date("Y-m-d", strtotime($request->date_payment));
            $purchasePayment->amount = $request->amount;
            $purchasePayment->payment_method = $request->payment_method;
            $purchasePayment->purchase_id = $request->purchase_id;
            $purchasePayment->caja_id = $caja->id;
            $purchasePayment->save();

            $purchase = purchases::find($request->purchase_id);
            $purchase->balance = $purchase->balance - $request->amount;
            if($purchase->balance == 0)
            {
                $purchase->payment_status = 'COMPLETADO';
            }
            $purchase->update();

            DB::connection('client')->commit();
            return 'success';

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);

        }
    }

    public function purchasePaymentDelete(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try
        {
            $purchasePayment = PurchasePayment::find($request->payment);
            $purchase = purchases::find($purchasePayment->purchase_id);
            $purchase->balance = $purchase->balance + $purchasePayment->amount;
            $purchase->update();
            $purchasePayment->delete();

            DB::connection('client')->commit();
            return 'success';
        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }
    }

    public function cancelPurchase(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{
            $purchase = purchases::find($request->id);
            $purchase->status = false;
            $purchase->payment_status = "ANULADO";
            $purchase->update();

            $purchaseDetails = purchaseDetail::where('purchase_id', $request->id)->get();

            foreach ($purchaseDetails as $item)
            {
                $product = Product::find($item->product_id);
                if($product->existence == 0)
                {
                    return response()->json(["message" => "La anulacion no puede ser efectiva. Uno de los productos se encuentra con la existencia en 0"], 400);
                }
                $product->existence = $product->existence - $item->quantity;
                $product->update();
            }

            DB::connection('client')->commit();
            return 'success';
        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }
    }

    public function printPurchase(Request $request)
    {
        $config = DB::connection('client')->table('configuracions')->first();
        $purchase = purchases::find($request->purchase_id);
        $purchaseDetails = DB::connection('client')
            ->table('purchase_details')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->where('purchase_details.purchase_id', $request->purchase_id)
            ->select('purchase_details.*', 'products.name')
            ->get();
        $purchase->details = json_decode($purchaseDetails, true);
        $supplier = Supplier::find($purchase->supplier_id);
        $purchase->supplier_name = $supplier->name;

        $previewData = [
          'company' => $config,
          'data' => $purchase
        ];

        return view('purchaseOrders.preview')
            ->with(compact('previewData', $previewData));
    }

}
