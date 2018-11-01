@foreach($facturasinicio as $factureinicio)
    <tr>
        <td>{{$factureinicio->date}}</td>
        <td>{{$factureinicio->id}}</td>
        <td class="text-left"><span class="pull-right">{{number_format($factureinicio->brute , 2)}}</span></td>
        <td class="text-left"><span class="pull-right">{{number_format($factureinicio->desc , 2)}}</span></td>
        <td class="text-left"><span class="pull-right">{{$factureinicio->itbis}}</span></td>
        <td class="text-left"><span class="pull-right">${{number_format($factureinicio->total_facture , 2)}}</span></td>
        <td class="text-center">{{number_format($factureinicio->Monto_efectivo,2)}}</td>
        <td class="text-center">{{number_format($factureinicio->Monto_tarjeta,2)}}</td>
    </tr>
@endforeach