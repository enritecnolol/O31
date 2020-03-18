<?php

namespace App\Http\Controllers;

use App\Caja;
use App\Product;
use App\purchaseDetail;
use App\PurchaseReturn;
use App\PurchaseReturnDetail;
use App\purchases;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnPurchasesController extends Controller
{
    //
    public function index()
    {
        return view('returnPurchases.index');
    }

    public function purchaseReturnData(Request $request)
    {
        $purchase = purchases::find($request->id);
        $purchase->details = DB::connection('client')
            ->select("
            select
               pd.id,
               p.name,
               pd.quantity - ifnull(sum((select sum(quantity) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) quantity,
               pd.price,
               pd.itbis - ifnull(sum((select sum(purchase_returns_details.itbis) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) itbis,
               pd.total - ifnull(sum((select sum(total) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) total,
               pd.product_id,
               pd.purchase_id
        from purchases
        join purchase_details pd on purchases.id = pd.purchase_id
        join products p on pd.product_id = p.id
        where purchases.id = $request->id
        group by pd.id;
            ");

        return $purchase;
    }
    public function store(Request $request)
    {
        $db = DB::connection('client');
        $db->beginTransaction();
        $config = $db->table('configuracions')->first();
        try{
            $caja = Caja::all()->last();
            $purchaseReturn = new PurchaseReturn();
            $purchaseReturn->date = now();
            $total_return = 0;
            foreach ($request->new_details as $item)
            {
                $total_return =  $total_return + ($item['price'] * $item['quantity']);
            }
            $purchaseReturn->total_return = $total_return;
            $purchaseReturn->purchase_id = $request->purchase_data['id'];
            $purchaseReturn->caja_id = $caja->id;
            $purchaseReturn->user_id = Auth::id();
            $purchaseReturn->save();

            foreach ($request->new_details as $item)
            {
                $purchaseReturnDetail = new PurchaseReturnDetail();
                $purchaseReturnDetail->product_id = $item['product_id'];
                $purchaseReturnDetail->quantity = $item['quantity'];
                $purchaseReturnDetail->price = $item['price'];
                $purchaseReturnDetail->itbis = $item['itbis'];
                $purchaseReturnDetail->bruto = $item['bruto'];
                $purchaseReturnDetail->total = $item['quantity'] * $item['price'];
                $purchaseReturnDetail->purchase_return_id = $purchaseReturn->id;
                $purchaseReturnDetail->save();

                if ($config->controlinv == 'si')
                {
                    $product = Product::find($item['product_id']);
                    $product->existence = $product->existence - $item['quantity'];
                    $product->update();
                }

            }

            $db->commit();
            return response()->json(['message' => 'La devolucion de compra se realizo con exito'], 200);
        }catch (\Exception $e)
        {
            $db->rollback();
            return response()->json($e, 400);
        }
    }

    public function printPurchaseReturn(Request $request)
    {
        $config = DB::connection('client')->table('configuracions')->first();
        $purchaseTotals = DB::connection('client')
            ->table('purchases')
            ->where('id', $request->id)
            ->selectRaw("id,
               (select sum(total_return) from purchase_returns where purchase_id in (purchases.id)) subtotal,
               (select sum(total_return) from purchase_returns where purchase_id in (purchases.id)) total
               "
            )->first();
        $purchase = purchases::find($request->id);

        $purchase->total = $purchaseTotals->total;
        $purchase->subtotal= $purchaseTotals->subtotal;

        $purchaseDetails = DB::connection('client')
            ->table('purchases')
            ->join(DB::raw('purchase_details pd'), 'purchases.id', '=', 'pd.purchase_id')
            ->join(DB::raw('products p'), 'pd.product_id', '=', 'p.id')
            ->where('purchases.id',$request->id)
            ->selectRaw("
               pd.id,
               p.name,
               pd.quantity - ifnull(sum((select sum(quantity) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) quantity,
               pd.price,
               pd.itbis - ifnull(sum((select sum(purchase_returns_details.itbis) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) itbis,
               pd.total - ifnull(sum((select sum(total) from purchase_returns_details where purchase_return_id in (select id from purchase_returns where purchase_returns.purchase_id =  purchases.id))), 0) total,
               pd.product_id,
               pd.purchase_id
               ")
            ->groupBy('pd.id')
            ->get();

        $purchase->details = json_decode($purchaseDetails, true);
        $supplier = Supplier::find($purchase->supplier_id);
        $purchase->supplier_name = $supplier->name;

        $previewData = [
            'company' => $config,
            'data' => $purchase
        ];

        return view('returnPurchases.preview')
            ->with(compact('previewData', $previewData));
    }

    public function getListPaginate($size = 10)
    {
        $query = DB::connection('client')
            ->table('purchase_returns')
            ->join('purchases', 'purchase_returns.purchase_id', '=', 'purchases.id')
            ->select('purchase_returns.*', 'purchases.invoice_date', 'purchases.document_no', 'purchases.kind_purchase')
            ->orderBy('id', 'desc')
            ->paginate($size);

        return $query;
    }

}
