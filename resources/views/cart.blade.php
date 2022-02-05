@extends('layouts.app')

@section('title')
<title>{{ $title }}</title>
@endsection

@section('content')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @php
                $summ = 0;
            @endphp
            @forelse ($products as $idx => $product)
                @php
                    $productSumm = $product->price * $product->quantity;
                    $summ += $productSumm;
                @endphp
                <tr>
                    <td>{{$idx + 1}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td class="product-buttons">
                        <form method="post" action="{{ route('removeFromCart') }}">
                            @csrf
                            <input name='id' hidden value="{{ $product->id }}">
                            <button @empty($product->quantity) disabled @endempty class="btn btn-danger">-</button>
                        </form>
                        {{ $product->quantity }}
                        <form method="post" action="{{ route('addToCart') }}">
                            @csrf
                            <input name='id' hidden value="{{ $product->id }}">
                            <button class="btn btn-success">+</button>
                        </form>
                    </td>
                    <td>
                        {{ $productSumm }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">
                        Корзина пока пуста, начните <a href="{{route('home')}}">покупать!</a>
                    </td>
                </tr>
            @endforelse
                <tr>
                    <td colspan="4" class="text-end">Итого:</td>
                    <td>
                        <strong>
                        {{ $summ }}
                        </strong>
                    </td>
                </tr>
        </tbody>
    </table>
    @if ($summ)
        <form method="post" action="{{ route('createOrder') }}">
            @csrf
            <input class="form-control mb-2" name="email" value="{{ $user->email ?? ''}}">
            <input class="form-control mb-2" name="address" value="{{ $user->addresses()->where('main', 1)->first()->address ?? ''}}">
            <button type="success" class="btn btn-succsess">Оформить заказ</button>
        </form>
    @endif
@endsection 