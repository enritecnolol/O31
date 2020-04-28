<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Impresion de Gasto</title>
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
                        <h2>Gasto</h2>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td style="width: 68%"><b>Provedor: </b>&emsp;{{$dataPDF['data']['name_supplier'] ? $dataPDF['data']['name_supplier'] : $dataPDF['data']['supplier_name']}}</td>
                            <td>

                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>No. gasto: </b></td>
                                        <td style="text-align: right">#{{$dataPDF['data']['id']}} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 68%"><b>Tipo NCF: </b>&emsp;{{$dataPDF['data']['type_expenses_name']}}</td>
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
                            <td style="width: 68%"><b>NFC: </b>&emsp;{{$dataPDF['data']['ncf']}}</td>
                            <td>
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>Condicion: </b></td>
                                        <td style="text-align: right">@if($dataPDF['data']['invoice_date']  == $dataPDF['data']['invoice_due']) Contado @else Credito @endif</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 68%"></td>
                            <td>
                                <table width="100%">
                                    <tbody>
                                    <tr>
                                        <td><b>Fecha vencimiento: </b> </td>
                                        <td style="text-align: right">{{ date("d-m-Y", strtotime($dataPDF['data']['invoice_due'])) }}</td>
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
                            <th style="text-align:left;font-weight: bold; border-bottom: 1px solid black;font-size:12px">Tipo de gasto</th>
                            <th style='text-align:left;font-weight: bold; border-bottom: 1px solid black; font-size: 12px'>Importe bruto</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Descuento</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Impuesto</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Total neto</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr style='text-align:right; border-width:1px;border-style:solid; border-color:#000000;'>
                                <td style="text-align:left;font-size: 14px;">
                                    {{$dataPDF['data']['type_expenses_name']}}
                                </td>
                                <td style="width: 15%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($dataPDF['data']['gross_amount'], 2, '.', ',')}}</td>
                                <td style="width: 15%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($dataPDF['data']['discount_amount'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($dataPDF['data']['tax_amount'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($dataPDF['data']['total_amount'], 2, '.', ',')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="" style="margin-top: 15px">
                    <div class="">
                        <div class="">
                            <label><b>Nota:</b></label>
                            <p>{{$dataPDF['data']['invoice_note']}}</p>
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
                    3000);
            }
        }
    })
</script>
</body>
</html>
