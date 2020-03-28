<?php

namespace App\Http\Controllers;

use App\InventoryAdjustments;
use App\InventoryAdjustmentsDetails;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryAdjustmentsController extends Controller
{
    //
    public function index()
    {
        return view('InventoryAdjustments.index');
    }

    public function store(Request $request)
    {

        DB::connection('client')->beginTransaction();
        try {

            $InventoryAdjustments = new InventoryAdjustments();
            $InventoryAdjustments->document = $request->document;
            $InventoryAdjustments->date_document = $request->date_document;
            $InventoryAdjustments->concept = $request->concept;
            $InventoryAdjustments->note = $request->note;
            $InventoryAdjustments->total = $request->total;
            $InventoryAdjustments->save();

            foreach ($request->details as $detail)
            {
                $InventoryAdjustmentsDetails = new InventoryAdjustmentsDetails();
                $InventoryAdjustmentsDetails->product_id = $detail['product']['code'];
                $InventoryAdjustmentsDetails->quantity = $detail['quantity'];
                $InventoryAdjustmentsDetails->amount = $detail['amount'];
                $InventoryAdjustmentsDetails->inventory_adjustments_id = $InventoryAdjustments->id;
                $InventoryAdjustmentsDetails->save();

                $product = Product::find($detail['product']['code']);
                $product->existence = $product->existence +  $detail['quantity'];
                $product->update();
            }

            DB::connection('client')->commit();
            return response()->json(['message' => 'El ajuste de inventario fue guardado con exito'], 200);
        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }
    }

    public function getList(Request $request)
    {
        $db = DB::connection('client');

        $query = $db->table('inventory_adjustments')
            ->paginate($request->size ? $request->size : 5);

        return $query;
    }
}
