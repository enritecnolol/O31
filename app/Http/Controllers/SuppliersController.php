<?php

namespace App\Http\Controllers;

use App\purchases;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuppliersController extends Controller
{
    //
    public function index()
    {
        return view('suppliers.index');
    }

    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->rnc = $request->rnc;
            $supplier->contact = $request->contact;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->observation = $request->observation;
            $supplier->save();

            DB::connection('client')->commit();
            return response()->json(['message' => 'El provedor ha sido guardado correctamente'], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function edit(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{

            $supplier = Supplier::find($request->id);
            $supplier->name = $request->name;
            $supplier->rnc = $request->rnc;
            $supplier->contact = $request->contact;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->observation = $request->observation;
            $supplier->update();

            DB::connection('client')->commit();
            return response()->json(['message' => 'El provedor ha sido modificado correctamente'], 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function supplierList($size = 10)
    {
        $db = DB::connection('client');

        $query = $db->table('suppliers')
            ->leftJoin('purchases', 'suppliers.id', '=', 'purchases.supplier_id')
            ->select('suppliers.*', DB::raw('ifnull(sum(purchases.balance), 0) balance'))
            ->groupBy('suppliers.id')
            ->paginate($size);

        return $query;
    }

    public function supplierListSelect()
    {
        $db = DB::connection('client');

        $query = $db->table('suppliers');

        return $query->get();
    }
    public function indexSupplierDetails()
    {
        return view('suppliers.supplierDetails');
    }

    public function supplierDetailsData(Request $request)
    {
        $supplier = Supplier::find($request->supplier_id);
//        $supplier->purchases= purchases::where('supplier_id', $request->supplier_id)->get();
        $supplier->balance = DB::connection('client')
            ->table('purchases')
            ->where('supplier_id', $request->supplier_id)
            ->select(DB::raw('sum(balance) balance'))
            ->first();
        $db = DB::connection('client');

        $purchase_payments = $db->table(DB::raw('purchase_payments pp'))
            ->join(DB::raw('purchases p'), 'pp.purchase_id', '=', 'p.id')
            ->where('p.supplier_id', $request->supplier_id)
            ->selectRaw("pp.id, p.document_no,'Compra' tipo ,pp.created_at, amount total, 0 balance, 'COMPLETADO' payment_status");

        $purchase =
            $db->table('purchases')
                ->where('supplier_id', $request->supplier_id)
                ->select('id', 'document_no', DB::raw("'Pago compra' as tipo"),'created_at', 'total', 'balance', 'payment_status')
                ->union($purchase_payments)
                ->orderBy('created_at', 'desc')
                ->get();

        $supplier->purchases = $purchase;

        return $supplier;
    }
}
