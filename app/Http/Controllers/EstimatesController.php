<?php

namespace App\Http\Controllers;

use App\Client_database;
use App\Core\ClientDbSwitcher;
use App\Estimate;
use App\EstimateDetail;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EstimatesController extends Controller
{
    public function index ()
    {
        return view('estimate.index');
    }

    public function confirmationEstimate ()
    {
        return view('estimate.confirmationEstimate');
    }

    public function confirmationEstimateDB (Request $request)
    {
        DB::connection('client')->beginTransaction();

        $clientDatabase = Client_database::where("auth_id", $request->auth)->first();

        try{
            ClientDbSwitcher::switchToDb(
                $clientDatabase
            );

            $estimate = Estimate::find($request->estimate);
            $estimate->confirmation = true;
            $estimate->confirmation_at = date('Y-m-d H:i');
            $estimate->update();

            DB::connection('client')->commit();
            return 'success';

        }catch (\Exception $e){
            DB::connection('client')->rollBack();
            return 'error';
        }
    }

    public function indextest ()
    {
        $company = DB::connection('client')->table('configuracions')->first();

        $data = [
            "company" => $company,
            "estimateNumber"=>"6541",
            "estimateDate"=>"2020-01-20",
            "dueDate"=>"2020-02-04",
            "client_id"=>["label"=>"Tomas Enrique","code"=>2],
            "address"=>"El creador del sistema",
            "email"=>"enritecnolol@gmail.com",
            "note"=>"So perhaps, you've generated some fancy text, and you're content that you can now copy and paste your fancy text in the comments section of funny cat videos, but perhaps you're wondering how it's even possible to change the font of your text? Is it some sort of hack? Are you copying and pasting an actual font?",
            "subtotal"=>1055,
            "total"=>1055,
            "details"=>
                [
                    ["product"=>
                        [
                            "label"=>"HOT DOG CON QUESO",
                            "code"=>8
                        ],
                        "description"=>"",
                        "quantity"=>"1",
                        "price"=>55,
                        "discount"=>0,
                        "amount"=>55
                    ],
                    [
                        "product"=>"",
                        "quantity"=>1,
                        "price"=>1000,
                        "discount"=>0,
                        "amount"=>1000,
                        "description"=>"esto es preuba"
                    ]
                ],
            "send"=>false
        ];

        $pdf = PDF::loadView('emails.estimate', compact(['data' => $data, 'company' => $company], 'data'), [], [
            'format' => 'A4-L'
        ]);

        return $pdf->stream();
    }

    public function store(Request $request)
    {
        DB::connection('client')->beginTransaction();

        if (count(DB::connection('client')->table('estimates')->where('estimatenumber', $request->estimateNumber)->get()) != 0)
        {
            return response()->json(['message' => 'El codigo de cotizacion en uso'], 400);
        }

        try{
            $estimate = new Estimate();
            $estimate->estimatenumber= $request->estimateNumber;
            $estimate->estimatedate = date("Y-m-d", strtotime($request->estimateDate));
            $estimate->duedate = date("Y-m-d", strtotime($request->dueDate));
            $estimate->client_id = $request->client_id['code'];
            $estimate->address = $request->address;
            $estimate->note = $request->note;
            $estimate->email = $request->email;
            $estimate->subtotal = $request->subtotal;
            $estimate->total = $request->total;
            $estimate->save();

            foreach ($request->details as $detail)
            {
                $estimateDetail = new EstimateDetail();
                if($detail['product']['label'])
                {
                    $estimateDetail->product = $detail['product']['label'];

                    if(isset($detail['product']['code']))
                    {
                        $estimateDetail->product_id = $detail['product']['code'];
                    }
                }
                $estimateDetail->description = $detail['description'];
                $estimateDetail->quantity = $detail['quantity'];
                $estimateDetail->price = $detail['price'];
                $estimateDetail->discount = $detail['discount'];
                $estimateDetail->amount = $detail['amount'];
                $estimateDetail->estimate_id = $estimate->id;
                $estimateDetail->save();
            }

            if($request->send)
            {
                $company = DB::connection('client')->table('configuracions')->first();
                $dataPDF = [
                    'data' => $request,
                    'company' => $company
                ];
                $pdf = PDF::loadView('emails.estimate', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $request->email;
                $dataMail = ['customer' => $request->client_id['label'], 'estimate' => $request->estimateNumber, 'auth_id' => Auth::id(), 'estimate_id' => $estimate];
                Mail::send('emails.estimatemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf) {
                    $message->to($email);
                    $message->subject('Cotizacion');
                    $message->attachData($pdf->output(), 'cotizacion.pdf');
                });
            }

            DB::connection('client')->commit();

            return 'success';
        }catch (\Exception $e)
        {
            DB::connection('client')->rollBack();
            return $e;
        }

    }

    public function edit(Request $request)
    {
        DB::connection('client')->beginTransaction();

        try {
            $estimateDetailDBId = array();
            $estimateDetailDB = DB::connection('client')->table('estimatedetails')->where('estimate_id', $request->id)->get();
            foreach ($estimateDetailDB  as $estimateD)
            {
                array_push($estimateDetailDBId, $estimateD->id);
            }

            $estimate = Estimate::find($request->id);
            $estimate->estimatenumber= $request->estimateNumber;
            $estimate->estimatedate = date("Y-m-d", strtotime($request->estimateDate));
            $estimate->duedate = date("Y-m-d", strtotime($request->dueDate));
            $estimate->client_id = $request->client_id['code'];
            $estimate->address = $request->address;
            $estimate->note = $request->note;
            $estimate->email = $request->email;
            $estimate->subtotal = $request->subtotal;
            $estimate->total = $request->total;
            $estimate->update();

            foreach ($request->details as $detail)
            {
                if(!array_key_exists('id',$detail))
                {
                    $estimateDetail = new EstimateDetail();
                    if($detail['product']['label'])
                    {
                        $estimateDetail->product = $detail['product']['label'];

                        if(isset($detail['product']['code']))
                        {
                            $estimateDetail->product_id = $detail['product']['code'];
                        }
                    }
                    $estimateDetail->description = $detail['description'];
                    $estimateDetail->quantity = $detail['quantity'];
                    $estimateDetail->price = $detail['price'];
                    $estimateDetail->discount = $detail['discount'];
                    $estimateDetail->amount = $detail['amount'];
                    $estimateDetail->estimate_id = $estimate->id;
                    $estimateDetail->save();
                }
                $estimateDetail = EstimateDetail::find($detail['id']);
                if(in_array($detail['id'], $estimateDetailDBId)){

                    if($detail['product']['label'])
                    {
                        $estimateDetail->product = $detail['product']['label'];

                        if(isset($detail['product']['code']))
                        {
                            $estimateDetail->product_id = $detail['product']['code'];
                        }
                    }
                    $estimateDetail->description = $detail['description'];
                    $estimateDetail->quantity = $detail['quantity'];
                    $estimateDetail->price = $detail['price'];
                    $estimateDetail->discount = $detail['discount'];
                    $estimateDetail->amount = $detail['amount'];
                    $estimateDetail->estimate_id = $estimate->id;
                    $estimateDetail->update();
                }else{
                    $estimateDetail->delete();
                }

            }

            if($request->send)
            {
                $company = DB::connection('client')->table('configuracions')->first();
                $dataPDF = [
                    'data' => $request,
                    'company' => $company
                ];
                $pdf = PDF::loadView('emails.estimate', compact($dataPDF, 'dataPDF'), [], [
                    'format' => 'A4-L'
                ]);
                $email = $request->email;
                $dataMail = ['customer' => $request->client_id['label'], 'estimate' => $request->estimateNumber, 'auth_id' => Auth::id(), 'estimate_id' => $estimate];
                Mail::send('emails.estimatemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf) {
                    $message->to($email);
                    $message->subject('Cotizacion');
                    $message->attachData($pdf->output(), 'cotizacion.pdf');
                });
            }

            DB::connection('client')->commit();

            return 'success';
        }catch (\Exception $e)
        {
            DB::connection('client')->rollBack();
            return $e;
        }

    }

    public function estimateList(Request $request)
    {

        $data = DB::connection('client')->table('estimates');

        $filters = json_decode($request['filters'],true);

        if($filters["customer"] != "")
        {
            $data->where('client_id', $filters["customer"]['code']);
        }

        if($filters['codeEstimate'])
        {
            $data->where('estimatenumber', $filters['codeEstimate']);
        }

        if($filters['from'] && $filters['to'])
        {
            $data->whereBetween('estimatedate', [
                date("Y-m-d", strtotime($filters['from'])),
                date("Y-m-d", strtotime($filters['to']))
            ]);
        }


        return $data->paginate(10);
    }

    public function getEstimateData(Request $request)
    {
        $estimate = Estimate::find($request->estimate_id);
        $estimate->estimate_details = DB::connection('client')->table('estimatedetails')->where('estimate_id', $request->estimate_id)->get();

        return $estimate;
    }

    public function resendEstimate(Request $request)
    {
        $estimate = Estimate::find($request->estimate_id);
        $estimate->details = DB::connection('client')->table('estimatedetails')->where('estimate_id', $request->estimate_id)->get();
        $customer_label = DB::connection('client')->table('clients')->where('id', $estimate->client_id)->first();
        $company = DB::connection('client')->table('configuracions')->first();

        foreach ($estimate->details as $key => $detail)
        {
            if($detail->product_id)
            {
                $estimate->details[$key]->product = ['label' => $detail->product];
            }else{
                $estimate->details[$key]->product = "";
            }

            if(!$detail->description)
            {
                $estimate->details[$key]->description = "";
            }
        }

        $dataPDF = [
            'data' => $estimate,
            'company' => $company
        ];
//        return $dataPDF ;
        $pdf = PDF::loadView('emails.estimate', compact($dataPDF, 'dataPDF'), [], [
            'format' => 'A4-L'
        ]);
        return $pdf->stream();
        $email = $estimate->email;
        $dataMail = ['customer' => $customer_label['nombre'], 'estimate' => $estimate->estimatenumber, 'auth_id' => Auth::id(), 'estimate_id' => $estimate['id']];

        Mail::send('emails.estimatemail', compact($dataMail, 'dataMail'), function ($message) use ($email, $pdf) {
            $message->to($email);
            $message->subject('Cotizacion');
            $message->attachData($pdf->output(), 'cotizacion.pdf');
        });

        return 'sent';
    }
}
