<?php

namespace App\Http\Controllers;

use App\Detallesecuencia;
use App\Expenses;
use App\Payment_expense_item;
use App\Payment_expenses;
use App\Supplier;
use App\Term;
use App\Type_expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpensesController extends Controller
{
    public function index()
    {
        return view('expenses.index');
    }

    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try {
            $expenses = new Expenses();
            $expenses->invoice_date = date("Y-m-d", strtotime($request->invoiceDate));
            $expenses->user_id = Auth::id();
            if(!isNull($request->supplier['code']))
            {
                $expenses->supplier_id = $request->supplier['code'];
            }else{
                $expenses->name_supplier = $request->supplier['label'];
            }
            $expenses->rnc = $request->rnc;
            $expenses->document = $request->document;
            $ncf = '';
            $aviso = '';
            $ncfDueDate = '';
            $config = DB::connection('client')->table('configuracions')->first();
            if ($config->generacomprobante == 'si' && $request->type_ncf != '01'){
                $expenses->type_ncf = $request->type_ncf;

                $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");
                foreach ($headers as $header)
                {
                    $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc',$request->type_ncf);
                    foreach ($details as $detail)
                    {
                        if (($detail->actual + $detail->aviso) >= $detail->secuencia_final){
                            $aviso = "En la Solicitud #". $header->id. " Serie: ". $detail->serie. ", Tipo de NCF: ".$request->type_ncf . " Se estan agotando";
                        }
                        if ($detail->actual < $detail->secuencia_final)
                        {
                            $ncfDueDate = $header->fechavencimiento;
                            $ncf = $detail->serie."".$detail->tipo_nfc."".str_pad($detail->actual,8,"0",STR_PAD_LEFT);
                            $d = Detallesecuencia::find($detail->id);
                            $d->actual = $detail->actual+1;
                            $d->update();
                            break;
                        }
                    }
                }
                if ($ncf == '')
                {
                    return response()->json([
                        'message' => 'No es posible completar la operacion por falta de comprobantes'
                    ],400);
                }
                $expenses->ncf = $ncf;
            }
            $expenses->ncf = $request->ncf;
            $expenses->type_expenses = $request->typeExpenses;
            $expenses->gross_amount = $request->grossAmount;
            $expenses->discount_amount = $request->discountAmount;
            $expenses->tax_amount = $request->taxAmount;
            $expenses->total_amount = $request->totalAmount;
            $expenses->invoice_balance = $request->totalAmount;
            $expenses->invoice_status = 1;
            $expenses->payment_process = "DEUDA";
            $expenses->invoice_note = $request->invoiceNote;
            $expenses->invoice_term_id = $request->term;
            $expenses->invoice_due = date("Y-m-d", strtotime($request->invoiceDue));
            $expenses->payment = $request->payment;
            $expenses->save();

            DB::connection('client')->commit();
            return response()->json([
                "message" => "Ha sido registrado con exito",
                "notification" => $aviso,
                "id" => $expenses->id
            ],200);

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollBack();
            return response()->json($exception,400);
        }
    }

    public function edit(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try {
            if(DB::connection('client')
                ->table('payment_expense_item')
                ->where('expense_id', $request->id)
                ->first())
            {
                return response()->json([
                    'message' => "No es posible editar este registro"
                ],400);
            }
            $expenses = Expenses::find($request->id);
            $expenses->invoice_date = date("Y-m-d", strtotime($request->invoiceDate));
            $expenses->user_id = Auth::id();
            if($request->supplier['code'])
            {
                $expenses->supplier_id = $request->supplier['code'];
            }else{
                $expenses->name_supplier = $request->supplier['label'];
            }
            $expenses->rnc = $request->rnc;
            $expenses->document = $request->document;
            $expenses->type_expenses = $request->typeExpenses;
            $expenses->gross_amount = $request->grossAmount;
            $expenses->discount_amount = $request->discountAmount;
            $expenses->tax_amount = $request->taxAmount;
            $expenses->total_amount = $request->totalAmount;
            $expenses->invoice_balance = $request->totalAmount;
            $expenses->invoice_status = 1;
            $expenses->invoice_note = $request->invoiceNote;
            $expenses->invoice_term_id = $request->term;
            $expenses->invoice_due = date("Y-m-d", strtotime($request->invoiceDue));
            $expenses->payment = $request->payment;
            $expenses->update();

            DB::connection('client')->commit();
            return response()->json([
                "message" => "Ha sido Editado con exito",
                "id" => $request->id
            ],200);

        }catch (\Exception $exception)
        {
            DB::connection('client')->rollBack();
            return response()->json($exception,400);
        }
    }

    public function ListPagination (Request $request)
    {

        $data = DB::connection('client')->table('expenses')
            ->join('terms', 'expenses.invoice_term_id', '=', 'terms.id');

        $filters = json_decode($request['filters'],true);

        if($filters["supplier"] != "")
        {
            $data->where('supplier_id', $filters["supplier"]['code']);
        }

        if($filters['codeExpenses'])
        {
            $data->where('id', $filters['codeExpenses']);
        }

        if($filters['status'] != "ALL")
        {
            $data->where('invoice_status', $filters['status']);
        }

        if($filters['from'] && $filters['to'])
        {
            $data->whereBetween('invoice_date', [
                date("Y-m-d", strtotime($filters['from'])),
                date("Y-m-d", strtotime($filters['to']))
            ]);
        }

        $data->orderBy('id', 'desc');

        $data->select('expenses.*', 'terms.name');

        return $data->paginate(10);
    }

    public function printExpenses(Request $request)
    {
        $config = DB::connection('client')->table('configuracions')->first();
        $expense = Expenses::find($request->expenses_id);
        $supplier = Supplier::find($expense->supplier_id);
        $expense->supplier_name = $supplier->name;
        $term = Term::find($expense->invoice_term_id);
        $expense->term_name = $term->name;
        $type_expenses_name = Type_expense::find($expense->type_expenses);
        $expense->type_expenses_name = $type_expenses_name->description;
        $dataPDF = [
            'data' => $expense ,
            'company' => $config,
            'term_days' => $term->number_days ? $term->number_days : 0
        ];

        return view('Print.expenses')->with(compact('dataPDF'));
    }

    public function typeExpensesList(Request $request)
    {
        return DB::connection('client')->table('type_expenses')->get();
    }

    public function SupplierExpenses(Request $request)
    {
        if($request->supplier_id)
        {
            $Expenses = DB::connection('client')
                ->table('expenses')
                ->where('supplier_id' , (int) $request->supplier_id)
                ->where('invoice_balance', '>', 0);
        }else{
            $Expenses = DB::connection('client')
                ->table('expenses')
                ->where('id' , (int) $request->expense_id);
        }

        return $Expenses->get();
    }

    public function PaymentIndex()
    {
        return view('expenses.payment');
    }

    public function paymentExpensesStore(Request $request)
    {
        DB::connection('client')->beginTransaction();
        try{

            $config = DB::connection('client')->table('configuracions')->first();

            $payment = new Payment_expenses();
            $payment->supplier_id = $request->supplier['code'];
            $payment->date = date("Y-m-d", strtotime($request->PaymentDate));
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
                    $payment_item = new Payment_expense_item();
                    $payment_item->expense_id = $item['id'];
                    $payment_item->original_amount = $item['total_amount'];
                    $payment_item->open_balance = $item['invoice_balance'];
                    $payment_item->pay = $item['amountReceived'];
                    $payment_item->discount = $item['discount'];
                    $payment_item->balance_before_pay = $item['BalanceAfterPay'];
                    $payment_item->payment_expense_id = $payment->id;

                    $expense = Expenses::find($item['id']);
                    $expense->invoice_balance = $item['invoice_balance'] - ($item['amountReceived'] + $item['discount']);
                    $expense->payment_process = 'DEUDA';

                    if($item['invoice_balance'] == ($item['amountReceived'] + $item['discount']))
                    {
                        $expense->invoice_balance = 0;
                        $expense->payment_process = 'COMPLETADO';
                    }

                    $expense->update();
                    $payment_item->save();
                }
            }

            DB::connection('client')->commit();
            return response()->json('success', 200);
        }catch (\Exception $e)
        {
            DB::connection('client')->rollback();
            return response()->json($e, 400);
        }
    }

    public function NCFSequence(Request $request)
    {
        $ncf = '';
        $aviso = '';
        $ncfDueDate = '';
        $config = DB::connection('client')->table('configuracions')->first();
        if ($config->generacomprobante == 'si'){
            $headers = DB::connection('client')->select("SELECT * FROM `headersecuencias` WHERE DATE(now()) BETWEEN headersecuencias.fechaemision AND headersecuencias.fechavencimiento");
            foreach ($headers as $header)
            {
                $details = Detallesecuencia::all()->where('header_secuencia_id', $header->id)->where('tipo_nfc',$request->type_ncf);
                foreach ($details as $detail)
                {
                    if (($detail->actual + $detail->aviso) >= $detail->secuencia_final){
                        $aviso = "En la Solicitud #". $header->id. " Serie: ". $detail->serie. ", Tipo de NCF: ".$request->type_ncf . " Se estan agotando";
                    }
                    if ($detail->actual < $detail->secuencia_final)
                    {
                        $ncfDueDate = $header->fechavencimiento;
                        $ncf = $detail->serie."".$detail->tipo_nfc."".str_pad($detail->actual,8,"0",STR_PAD_LEFT);
                        $d = Detallesecuencia::find($detail->id);
                        $d->actual = $detail->actual+1;
                        $d->update();
                        break;
                    }
                }
            }

            if ($ncf == '')
            {
                return response()->json([
                    'message' => 'No es posible completar la operacion por falta de comprobantes'
                ],400);
            }

            return response()->json(["ncf" => $ncf], 200);
        }

        return response()->json([
            'message' => 'Actualmente usted no pose el uso de comprobantes Activo'
        ],400);
    }
}
