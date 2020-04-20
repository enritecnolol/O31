<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Impresion de Factura</title>
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
            size: portrait;
            @bottom-center {
                content: counter(page) " de " counter(pages);
            }
        }
    </style>
</head>
<body>
<div class="" id="Vue" style="padding: 10px">
    <div class="">
        <div class="">
            <div class="" id="header">
                <div class="">
                    <img src="{{ URL::asset('imagenes/'.$dataPDF['company']->img)}}" alt="" style="width: 100px;">
                </div>
                <div class="" style="margin-top: 20px">
                    <b style="font-size: 22px">{{$dataPDF['company']->nombreempresa}} <br></b>
                    <p>{{$dataPDF['company']->telefono}} <br> {{$dataPDF['company']->pais}}, <br> {{$dataPDF['company']->ciudad}}
                        <br> {{$dataPDF['company']->direccion}} </p>
                </div>
                <div class="">
                    <div class="">
                        <h2>Factura</h2>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td style="width: 68%"><b>Cliente: </b>&emsp;{{$dataPDF['data']['client_name']}}</td>
                            <td>

                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>No. Factura: </b></td>
                                        <td style="text-align: right">#{{$dataPDF['invoice_id']}} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 68%"><b>Direccion: </b>&emsp;#{{$dataPDF['data']['address']}}</td>
                            <td>
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>Fecha: </b></td>
                                        <td style="text-align: right">{{date("d-m-Y h:i:s A", strtotime($dataPDF['data']['created_at']))}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 68%"><b>Email: </b>&emsp;{{$dataPDF['data']['email']}}</td>
                            <td>
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>Condicion: </b></td>
                                        <td style="text-align: right">@if($dataPDF['term_days']  == 0) Contado @else Credito {{$dataPDF['term_days']}} dias @endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 68%"><b>RNC/Cedula: </b>&emsp;{{$dataPDF['data']['datancf']['rnc']}}</td>
                            <td>
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>Fecha vencimiento: </b> </td>
                                        <td style="text-align: right">{{ date("d-m-Y", strtotime($dataPDF['data']['due_date'])) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
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
                                <td style="text-align:left;font-size: 14px;">
                                    {{$detail['name_product']}}
                                </td>
                                <td style="width: 40%;text-align:left;font-size: 14px;border-left: 1px solid black">{{$detail['description']}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{$detail['quanlity']}}</td>
                                <td style="width: 15%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['price'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['descuento'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['amount'], 2, '.', ',')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="" style="margin-top: 15px">
                    <div class="">
                        <div style="margin-right: 2px;float: right;width: 200px;height: auto;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;">
                            <table  width="100%">
                                <tbody>
                                <tr>
                                    <td style="text-align: left"><b>SubTotal:</b></td>
                                    <td style="text-align: right">$ {{number_format($dataPDF['data']['brute'], 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left"><b>Descuento:</b></td>
                                    <td style="text-align: right">$ {{number_format($dataPDF['data']['desc'], 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td style="text-align: left"><b>Impuesto:</b></td>
                                    <td style="text-align: right">$ {{number_format($dataPDF['data']['itbis'], 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: left"><b>Total:</b></td>
                                    <td style="text-align: right">RD$ {{number_format($dataPDF['data']['total_facture'], 2, '.', ',')}}</td>
                                </tr>
                                </tbody>
                            </table>
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
<script src="{{ URL::asset('js/vue.js') }}"></script>
<script !src="">
    var app = new Vue({
        el: '#Vue',
        methods:{
            getUrlVars()
            {
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            },
        },
        created(){
            if(!this.getUrlVars(window.location.href)['print'])
            {
                window.print();
                setTimeout(() => {
                    window.close();
                    },
                    3000
                );
            }
        }
    })
</script>
</body>
</html>
