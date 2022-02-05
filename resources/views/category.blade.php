@extends('layouts.app')

@section ('title')
<title>{{ $category->name }}</title>
@endsection

@section ('content')
<div class="container">
    <div class="row">
        @foreach ($products as $product)
            <div class="col-3">
                <div class="card mb-4" style="width: 14rem">
                    <img src="{{ asset('storage') }}/{{ $product->picture }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <div class="product-name">
                                <h5 class="card-title">{{$product->name}}</h5>
                            </div> 
                            <p class="card-text">{{$product->description}}</p>
                            <div class="product-price">
                                {{ $product->price }} руб.
                            </div>
                            <div class="product-buttons">
                                <form method="post" action="{{ route('removeFromCart') }}">
                                    @csrf
                                    <input name='id' hidden value="{{ $product->id }}">
                                    <button @empty(session("cart.$product->id")) disabled @endempty class="btn btn-danger">-</button>
                                </form>
                                {{ session("cart.$product->id") ?? 0 }}
                                <form method="post" action="{{ route('addToCart') }}">
                                    @csrf
                                    <input name='id' hidden value="{{ $product->id }}">
                                    <button class="btn btn-success">+</button>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection