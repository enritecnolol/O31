<?php

namespace App\Http\Controllers;

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
        DB::beginTransaction();
        try{

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->rnc = $request->rnc;
            $supplier->contact = $request->contact;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->observation = $request->observation;
            $supplier->save();

            DB::commit();
            return response()->json(['message' => 'El provedor ha sido guardado correctamente'], 200);
        }catch (\Exception $e)
        {
            DB::rollback();
            return response()->json($e, 400);
        }
    }

    public function edit(Request $request)
    {
        DB::beginTransaction();
        try{

            $supplier = Supplier::find($request->id);
            $supplier->name = $request->name;
            $supplier->rnc = $request->rnc;
            $supplier->contact = $request->contact;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->observation = $request->observation;
            $supplier->update();

            DB::commit();
            return response()->json(['message' => 'El provedor ha sido modificado correctamente'], 200);
        }catch (\Exception $e)
        {
            DB::rollback();
            return response()->json($e, 400);
        }
    }

    public function supplierList($size = 10)
    {
        $db = DB::connection('client');

        $query = $db->table('suppliers')->paginate($size);

        return $query;
    }
}
