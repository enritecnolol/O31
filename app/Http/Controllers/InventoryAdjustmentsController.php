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
            $InventoryAdjustments->document = "0";
            $InventoryAdjustments->date_document = $request->date_document;
            $InventoryAdjustments->concept = $request->concept;
            $InventoryAdjustments->note = $request->note;
            $InventoryAdjustments->total = $request->total;
            $InventoryAdjustments->fit_type = $request->fitType;
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

                if($request->fitType == "EI")
                {
                    $product->existence = $product->existence +  $detail['quantity'];
                }else if($request->fitType == "SI")
                {
                    $product->existence = $product->existence - $detail['quantity'];
                }else{
                    $product->existence = $detail['quantity'];
                }

                $product->update();
            }

            $company = DB::connection('client')->table('configuracions')->first();

            DB::connection('client')->commit();
            return response()->json([
                'message' => 'El ajuste de inventario fue guardado con exito',
                'document_id' => $InventoryAdjustments->id,
                'company' => $company
            ], 200);
        }catch (\Exception $exception)
        {
            DB::connection('client')->rollback();
            return response()->json($exception, 400);
        }
    }

    public function getList(Request $request)
    {
        $db = DB::connection('client');

        $query = $db->table('inventory_adjustments');
        if($request->search)
        {
            $query = $query->where('id', $request->search);
        }
        $query = $query->paginate($request->size ? $request->size : 5);

        return $query;
    }

    public function getData(Request $request)
    {
        $InventoryAdjustments = InventoryAdjustments::find($request->id);

        $InventoryAdjustmentsDetails =  DB::connection('client')
            ->table('inventory_adjustments_details')
            ->join('products', 'inventory_adjustments_details.product_id', '=', 'products.id')
            ->where('inventory_adjustments_id', $request->id)
            ->select('inventory_adjustments_details.*', 'products.name')
            ->get();

        $company = DB::connection('client')->table('configuracions')->first();

        return response()->json([
            'InventoryAdjustments' => $InventoryAdjustments,
            'InventoryAdjustmentsDetails' => $InventoryAdjustmentsDetails,
            'company' => $company
        ], 200);

    }
}
