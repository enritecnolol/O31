<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Impresion de Compra</title>
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
            size: landscape;
            @bottom-center {
                content: counter(page) " de " counter(pages);
            }
        }
    </style>
</head>
<body>
<div class="" id="Vue">
    <div class="">
        <div class="">
            <div class="" id="header">
                <div class="">
                    <img src="{{ URL::asset('imagenes/'.$previewData['company']->img)}}" alt="" style="width: 100px;">
                </div>
                <div class="" style="margin-top: 20px">
                    <b>{{$previewData['company']->nombreempresa}} <br></b>
                    <b>{{$previewData['company']->telefono}} </b>
                    <p>{{$previewData['company']->pais}}, {{$previewData['company']->ciudad}} {{$previewData['company']->direccion}}</p>
                </div>
                <div class="">
                    <div class="">
                        <h3>Devolucion de compra</h3>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td><b>Cliente: </b>{{$previewData['data']['supplier_name']}}</td>
                            <td><b>Fecha: </b> {{ date("d-m-Y", strtotime($previewData['data']['created_at'])) }}</td>
                            <td><b>Fecha factura: </b> {{date("d-m-Y", strtotime($previewData['data']['invoice_date']))}}</td>
                        </tr>
                        <tr>
                            <td><b>No. Documento: </b> #{{$previewData['data']['document_no']}}</td>
                            <td><b>Orden de compra: </b> No relacionada</td>
                            <td><b>Tipo de compra: </b> @if($previewData['data']['kind_purchase'] ==  "credit") Credito @else De contado @endif</td>
                        </tr>
                        @if($previewData['company']->generacomprobante == 'si')
                            <tr>
                                <td><b>NCF: </b> {{$previewData['data']['ncf']}}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="content" style="margin-top: 20px">
                <div class="">
                    <table width="100%" style='border: 1px solid black;'>
                        <thead>
                        <tr  style='border: 1px solid black;font-weight: bold'>
                            <th style="text-align:left;font-weight: bold; border-bottom: 1px solid black;font-size:12px">Producto</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Cantidad</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Precio</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Itbis</th>
                            <th style='font-weight: bold; border-bottom: 1px solid black; font-size: 12px;text-align: right'>Importe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($previewData['data']['details'] as $detail)
                            <tr style='text-align:right; border-width:1px;border-style:solid; border-color:#000000;'>
                                <td style="text-align:left;font-size: 14px;">{{$detail['name']}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{$detail['quantity']}}</td>
                                <td style="width: 15%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['price'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['itbis'], 2, '.', ',')}}</td>
                                <td style="width: 10%;text-align:right;font-size: 14px;border-left: 1px solid black">{{number_format($detail['total'], 2, '.', ',')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="" style="margin-top: 15px">
                    <div class="">
                        <div style="margin-right: 2px;float: right;width: 200px;height: 150px;box-shadow: 0px 0px 3px 0px rgba(0,0,0,0.75);border-radius: 10px 10px 10px 10px;">
                            <div class="">
                                <div class="">
                                    <div class="" style="margin-top: 10px;text-align: right"><b>SubTotal:</b></div>
                                    <div class="" style="margin-top: 10px;text-align: right">RD$ {{number_format($previewData['data']['subtotal'], 2, '.', ',')}}</div>
                                    <div class="">
                                        <hr>
                                    </div>
                                    <div class="" style="text-align: right"><b>Monto Total:</b></div>
                                    <div class="" style="text-align: right">RD$ {{number_format($previewData['data']['total'], 2, '.', ',')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <label><b>Nota:</b></label>
                            <p>{{$previewData['data']['note']}}</p>
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
            }
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