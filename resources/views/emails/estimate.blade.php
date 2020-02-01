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
        @media print and (width: 8.5in) and (height: 11in) {
            @page {
                margin: 10px;
                size: landscape;
            }
        }
        div#footer {
            font-size: 12px;
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
<div class="">
    <div class="">
        <div class="">
            <div class="" id="header">
                <div class="">
                    <img src="{{$dataPDF['company']->img}}" alt="" style="width: 100px;">
                </div>
                <div class="" style="margin-top: 20px">
                    <b>{{$dataPDF['company']->nombreempresa}} <br></b>
                    <b>{{$dataPDF['company']->telefono}} </b>
                    <p>{{$dataPDF['company']->pais}}, {{$dataPDF['company']->ciudad}} {{$dataPDF['company']->direccion}}</p>
                </div>
                <div class="">
                    <div class="">
                        <h3>Cotizacion</h3>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td><b>Cliente: </b>{{$dataPDF['data']['client_id']['label']}}</td>
                            <td><b>Fecha estimada: </b> {{date("d-m-Y", strtotime($dataPDF['data']['estimateDate']))}}</td>
                            <td><b>Fecha vencimiento: </b> {{ date("d-m-Y", strtotime($dataPDF['data']['dueDate'])) }}</td>
                        </tr>
                        <tr>
                            <td><b>No. Cotización: </b> #{{$dataPDF['data']['estimateNumber']}}</td>
                            <td><b>Dirección: </b> {{$dataPDF['data']['address']}}</td>
                            <td><b>Email :</b> {{$dataPDF['data']['email']}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="content" style="margin-top: 20px">
                <div class="">
                    <table width="100%" style='border: 1px solid black;'>
                        <thead>
                        <tr  style='border: 1px solid black;font-weight: bold'>
                            <th style="text-align:left;font-weight: bold; border-bottom: 1px solid black;font-size:12px">Producto/Servicio</th>
                            <th style='text-align:left;font-weight: bold; border-bottom: 1px solid black; font-size: 12px'>Descripción</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Cantidad</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Precio</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Descuento</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Importe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataPDF['data']['details'] as $detail)
                            <tr style='text-align:right; border-width:1px;border-style:solid; border-color:#000000;'>
                                <td style="text-align:left;font-size: 11px;">
                                    @if($detail['product'])
                                        {{$detail['product']['label']}}
                                    @endif
                                </td>
                                <td style="width: 40%;text-align:left;font-size: 11px;border-left: 1px solid black">{{$detail['description']}}</td>
                                <td style="width: 10%;text-align:right;font-size: 11px;border-left: 1px solid black">{{$detail['quantity']}}</td>
                                <td style="width: 15%;text-align:right;font-size: 11px;border-left: 1px solid black">{{number_format($detail['price'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 11px;border-left: 1px solid black">{{$detail['discount']}}</td>
                                <td style="width: 10%;text-align:right;font-size: 11px;border-left: 1px solid black">{{number_format($detail['amount'], 2, '.', ',')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="" style="margin-top: 15px">
                    <div class="">
                        <div style="float: right;width: 200px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;">
                            <div class="">
                                <div class="">
                                    <div class="" style="margin-top: 10px;text-align: right"><b>SubTotal:</b></div>
                                    <div class="" style="margin-top: 10px;text-align: right">RD$ {{number_format($dataPDF['data']['subtotal'], 2, '.', ',')}}</div>
                                    <div class="">
                                        <hr>
                                    </div>
                                    <div class="" style="text-align: right"><b>Monto Total:</b></div>
                                    <div class="" style="text-align: right">RD$ {{number_format($dataPDF['data']['total'], 2, '.', ',')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <label><b>Nota:</b></label>
                            <p>{{$dataPDF['data']['note']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>