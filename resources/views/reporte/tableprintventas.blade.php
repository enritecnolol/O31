<div class="container">
    <div class="">
        <img  src="imagenes/{{$empresa[0]->img}}" alt="">
        <br>
        <div class="text-center">
            <h5>Desde: {{$start}}  Hasta: {{$end}}</h5>
        </div>
        <hr>
    </div>
</div>

<div class="container" style="">
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th scope="col" class="text-left"><span class="pull-right">Fecha</span></th>
            <th scope="col" class="text-left"><span class="pull-right">No.factura</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Bruto</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Desc</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Itbis</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Total</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Efectivo</span></th>
            <th scope="col" class="text-left"><span class="pull-right">Tarjeta</span></th>
        </tr>
        </thead>
        <tbody>
        @foreach($facturasinicio as $factureinicio)
            <tr>
                <td class="text-center">{{$factureinicio->date}}</td>
                <td class="text-center">{{$factureinicio->id}}</td>
                <td class="text-left"><span class="pull-right">{{number_format($factureinicio->brute , 2)}}</span></td>
                <td class="text-left"><span class="pull-right">{{number_format($factureinicio->desc , 2)}}</span></td>
                <td class="text-left"><span class="pull-right">{{$factureinicio->itbis}}</span></td>
                <td class="text-left"><span class="pull-right">${{number_format($factureinicio->total_facture , 2)}}</span></td>
                <td class="text-left"><span class="pull-right">{{number_format($factureinicio->Monto_efectivo - $factureinicio->returns,2)}}</span></td>
                <td class="text-left"><span class="pull-right">{{number_format($factureinicio->Monto_tarjeta,2)}}</span></td>
            </tr>
        @endforeach
        </tbody>
        <tr>
            <td></td>
            <td><strong>Total:</strong></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->bruto , 2)}}</strong></span></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->descuento , 2)}}</strong></span></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->itbis , 2)}}</strong></span></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->total , 2)}}</strong></span></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->efectivo , 2)}}</strong></span></td>
            <td class="text-left"><span class="pull-right"><strong>${{number_format($total[0]->tarjeta , 2)}}</strong></span></td>
        </tr>
    </table>
</div>