@extends('layouts.app')

@section('title')
<title>{{ $title }}</title>
@endsection

@section('content')
<table class="table table-bordered align-middle">
    <thead class="text-center">
        <th>#</th>
        <th>Дата</th>
        <th>Товары</th>
        <th>Стоимость</th>
        <th>Повторить заказ</th>
    </thead>
    <tbody>
        @forelse ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                @php
                    $products = $order->products;
                    $summ = 0;
                @endphp    
                @foreach ($products as $product)
                    @php 
                        
                    @endphp 
                    {{ $product->name }} ({{ $product->pivot->quantity }} шт.) <b>{{ $product->pivot->price }} р.</b> <br>
                    @php
                        $productSum = $product->pivot->price * $product->pivot->quantity;
                        $summ = $summ + $productSum;                   
                    @endphp
                    @endforeach
                    <td>{{ $summ }} р.</td>
                    <td class="text-center">
                        <form method="get" action="{{ route('repeatOrder', [Auth::user()->id, $order->id]) }}">
                            @csrf
                            <input name="order_id" hidden value="{{ $order->id }}">
                            <button class="btn btn-primary btn-success"><i class="fa-solid fa-repeat"></i></button>
                        </form>                        
                    </td>
            </td>               
            
        </tr>
        @empty
        <tr>
            <td class="text-center" colspan="5">Нет заказов</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection