@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class="table-responsive">
    <h1>Список продуктов</h1>
    <table class="table table-bordered align-middle">
        <thead class="text-center">
            <th>#</th>
            <th>Изображение</th>
            <th>Категория</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
        </thead>
        <tbody>
            @if ($categories)
                @foreach ($categories as $category)
                    @php $products = $category->products; @endphp
                    @forelse ($products as $product)
                        <tr>                
                            <td class="text-center">{{ $product->id }}</td>
                            <td style="width: 150px;">
                                <img src="{{ asset('storage') }}/{{ $product->picture }}" class="img-thumbnail" alt="{{ $product->name }}">
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>                               
                        </tr>
                    @empty
                    @endforelse 
                @endforeach
            @else
            @php $products = $category->products; @endphp
            @foreach ($products as $product)
                <tr>                
                    <td class="text-center">{{ $product->id }}</td>
                    <td style="width: 150px;">
                        <img src="{{ asset('storage') }}/{{ $product->picture }}" class="img-thumbnail" alt="{{ $product->name }}">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>                               
                </tr>
            @endforeach
            @endif       
        </tbody>
    </table>
</div>
@endsection