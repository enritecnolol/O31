<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <style>
        body {
            margin: 5px 0px 0px 5px;
        }
        div#header {
            top:0px;
            left:0px;
            width:100%;
            padding:8px;
        }
        div#content {
            margin-top: 5px;
        }
        @page {
            margin: 5px;
            size: landscape;
        }
        @media print and (width: 8.5in) and (height: 16in) {
            @page {
                margin: 10px;
                size: landscape;
            }
        }
        div#footer {
            font-size: 20px;
            border-top: 0.5px solid black;
            position:fixed;
            bottom:0px;
            left:0px;
            width:100%;
            padding:8px;
        }
        @media print{
            tr:nth-child(odd) {
                background-color:rgba(159,159,176,0.36);
            }
            tr:nth-child(even) {
                background-color:#ffffff;
            }
            @page {
                margin: 10px;
                size: landscape;
            }
        }
        @page{
            size: landscape;
            @bottom-center {
                content: counter(page) " de " counter(pages);
            }
        }
    </style>
</head>
<body>
<div class="" style="width: 99%">
    <div class="">
        <div class="">
            <div class="" id="header">
                <div class="">
                    <img src="{{ URL::asset('imagenes/'.$dataPDF['company']->img)}}" alt="" style="width: 100px;">
                </div>
                <div class="" style="margin-top: 20px;font-size: 22px;height: 100px">
                    <div style="float: left">
                        <b>{{$dataPDF['company']->nombreempresa}}</b>
                        <br>
                        {{$dataPDF['company']->pais}}, {{$dataPDF['company']->ciudad}} {{$dataPDF['company']->direccion}}
                        <br>{{$dataPDF['company']->telefono}}
                    </div>
                    <div style="float: right;">
                        <b>Fecha: </b> {{date("d-m-Y h:i:sa")}} <br>
                        <b>Cliente: </b> {{$dataPDF['data']['client_id']['label']}} <br>
                        <b>Metodo de pago: </b> {{$dataPDF['data']['payment_method_id']['label']}}
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <h2>Recibo de pago</h2>
                    </div>
                </div>

                <hr>
                {{--<div class="row">--}}
                {{--<table width="100%">--}}
                {{--<tbody>--}}
                {{--<tr>--}}
                {{--<td><b>Cliente: </b>{{$dataPDF['data']['client_id']['label']}}</td>--}}
                {{--<td><b>Fecha estimada: </b> {{date("d-m-Y", strtotime($dataPDF['data']['invoice_date']))}}</td>--}}
                {{--<td><b>Fecha vencimiento: </b> {{ date("d-m-Y", strtotime($dataPDF['data']['due_date'])) }}</td>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<td><b>No. Factura: </b> #{{$dataPDF['invoice_id']}}</td>--}}
                {{--<td><b>Dirección: </b> {{$dataPDF['data']['address']}}</td>--}}
                {{--<td><b>Email :</b> {{$dataPDF['data']['email']}}</td>--}}
                {{--</tr>--}}
                {{--@if($dataPDF['fiscal']['config'] == 'si')--}}
                {{--<tr>--}}
                {{--<td><b>NCF: </b> {{$dataPDF['fiscal']['ncf']}}</td>--}}
                {{--<td><b>Fecha vencimiento NCF: </b> {{$dataPDF['fiscal']['NFCDueDate']}}</td>--}}
                {{--<td></td>--}}
                {{--</tr>--}}
                {{--@endif--}}
                {{--</tbody>--}}
                {{--</table>--}}
                {{--</div>--}}
            </div>
            <div id="content" style="margin-top: 20px">
                <div class="">
                    <table width="100%" style='border: 1px solid black;'>
                        <thead>
                        <tr  style='border: 1px solid black;font-weight: bold'>
                            <th style='text-align:left;font-weight: bold; border-bottom: 1px solid black; font-size: 20px'>Descripción</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: left'>Fecha de vencimiento</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: right'>Monto original</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: right'>Balance pendiente</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: right'>Pago</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: right'>Descuento</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 20px;text-align: right'>Balance despues de pagado</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataPDF['data']['items'] as $detail)
                            @if($detail['amountReceived'] > 0)
                                <tr style='text-align:right; border-width:1px;border-style:solid; border-color:#000000;'>
                                    <td style="text-align:left;font-size: 14px;width: 40%;">
                                        Factura #{{$detail['id']}} ({{$detail['date']}})
                                    </td>
                                    <td style="text-align:left;font-size: 14px;border-left: 1px solid black">{{$detail['due_date']}}</td>
                                    <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['total_facture'], 2, '.', ',')}}</td>
                                    <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['open_balance'], 2, '.', ',')}}</td>
                                    <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['amountReceived'], 2, '.', ',')}}</td>
                                    <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['discount'], 2, '.', ',')}}</td>
                                    <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['open_balance'] - ($detail['discount'] + $detail['amountReceived']) , 2, '.', ',')}}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="" style="margin-top: 15px;">
                    <div class="">
                        <div style="float: right;width: 200px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;">
                            <div class="">
                                <div style="margin-top: 20px">
                                    <div>
                                        <div class="" style="float: left"><b>Monto Total:</b> RD$ {{number_format($dataPDF['data']['amount'], 2, '.', ',')}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>