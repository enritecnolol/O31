<?php

namespace App\Http\Controllers;

use App\Payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodsController extends Controller
{
    public function index()
    {
        return view('payments.index');
    }

    public function store(Request $request)
    {
        if(count(DB::connection('client')->table('payment_methods')->where('name', $request->name)->get()) != 0)
        {
            return response()->json(['message' => 'Este metodo de pago existe'], 400);
        }

        DB::beginTransaction();
        try{

            $paymentMethod = new Payment_method();
            $paymentMethod->name =  $request->name;
            $paymentMethod->save();

            DB::commit();
            return 'success';
        }catch (\Exception $e)
        {
            DB::rollback();
            return response()->json($e, 400);
        }
    }

    public function getPaginate($size = 5)
    {
        $data = DB::connection('client')->table('payment_methods')->paginate($size);
        return $data;
    }

    public function getWithoutPaginate()
    {
        $data = DB::connection('client')->table('payment_methods')->get();
        return $data;
    }

    public function edit(Request $request)
    {
        if(count(DB::connection('client')->table('payment_methods')->where('name', $request->name)->get()) != 0)
        {
            return response()->json(['message' => 'Este metodo de pago existe'], 400);
        }

        DB::beginTransaction();
        try{

            $paymentMethod = Payment_method::find($request->id);
            $paymentMethod->name =  $request->name;
            $paymentMethod->update();

            DB::commit();
            return 'edited';
        }catch (\Exception $e)
        {
            DB::rollback();
            return response()->json($e, 400);
        }
    }
}
