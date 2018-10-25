
@foreach($facturas as $factura)
    <tr>
        <td>{{$factura->date}}</td>
        <td>{{$factura->id}}</td>
        <td>{{number_format($factura->Monto_efectivo,2)}}</td>
        <td>{{number_format($factura->Monto_tarjeta,2)}}</td>
        <td>${{number_format($factura->total_facture , 2)}}</td>
    </tr>
@endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><strong>Total :</strong></td>
        <td><strong>${{number_format($total[0]->total,2)}}</strong></td>
    </tr>


