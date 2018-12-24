@foreach($productos as $productos)
    <tr>
        <td>{{$productos->name}}</td>
        <td>{{$productos->cantidad}}</td>
        <td class="text-left"><span class="pull-right">{{number_format($productos->impost , 2)}}</span></td>
    </tr>
@endforeach