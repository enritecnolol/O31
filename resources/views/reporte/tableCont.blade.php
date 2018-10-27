
@foreach($facturas as $factura)
    <tr>
        <td>{{$factura->date}}</td>
        <td>{{$factura->id}}</td>
        <td class="text-center">{{number_format($factura->Monto_efectivo,2)}}</td>
        <td class="text-center">{{number_format($factura->Monto_tarjeta,2)}}</td>
        <td class="text-left"><span class="pull-right">{{number_format($factura->brute , 2)}}</span></td>
        <td class="text-left"><span class="pull-right">{{number_format($factura->desc , 2)}}</span></td>
        <td class="text-left"><span class="pull-right">{{number_format($factura->itbis , 2)}}</span></td>
        <td class="text-left"><span class="pull-right">${{number_format($factura->total_facture , 2)}}</span></td>
    </tr>
@endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Total :</strong></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-left"><strong class="pull-right">${{number_format($total[0]->total,2)}}</strong></td>
    </tr>


