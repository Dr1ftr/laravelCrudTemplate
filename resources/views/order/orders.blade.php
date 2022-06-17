<x-app-layout>

<link rel="stylesheet" href="{{ mix('/css/order_overview.css') }}">
   
<div class="margin">
<div class="center">

<table>

<tr>
    <th>Gebruiker</th>
    <th>Product</th>
    <th>Totaal producten</th>
    <th>Prijs</th>
  </tr>
@foreach($orders as $order)
    
  <tr>
    <td>{{$order->name}}</td>
    <td>{{$order->name_product}}</td>
    <td>{{$order->total_amount}}</td>
    <td>€{{number_format($order->price)}}</td>
    
  </tr>
  @endforeach
</table>

</div>
  
</div>

</x-app-layout>