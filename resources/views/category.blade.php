@extends('layouts.app')

@section ('title')
<title>Категория</title>
@endsection

@section ('content')
<div class="container">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-4">
            <div class="card mb-4" style="width: 18rem">
                <img src="{{ asset('storage') }}/{{ $product->picture }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5> 
                        <p class="card-text">{{$product->description}}</p>
                        <div>
                            {{ $product->price }} руб.
                        </div>
                    </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection