@extends('layouts.app')

@section('title')
<title>{{ $title }}</title>
@endsection

@section('content')
<table class="table table-bordered">
    <thead>
        <th>#</th>
        <th>Дата</th>
        <th>Товаров</th>
    </thead>
    <tbody>
        @forelse ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>
                @php
                    $products = $order->products;
                @endphp    
                @foreach ($products as $product) 
                    {{ $product->name }} <br>
                @endforeach
            </td>
        </tr>
        @empty
        <tr>
            <td class="text-center" colspan="3">Нет заказов</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection