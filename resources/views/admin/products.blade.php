@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class="table-responsive">
    <h1>Список продуктов</h1>
        <form method="post" action="{{ route ('adminProductsFilter') }}">
            @csrf
            <div style="display: flex; flex-direction: row; justify-content: flex-start;" class="mb-4">       
                <div style="margin-right: 5px; width:300px">            
                        <select name="category_id" class="form-select" aria-label="Default select example">
                        <option value="0" @if (!$oneCategory) selected @endif>Все категории</option>
                            @foreach ($categories as $category)
                                <option @if ($oneCategory && $oneCategory->id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>            
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Выбрать</button>
                </div>        
            </div>
        </form>
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
            @if (!$oneCategory)
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
                    <tr>
                        <td class="text-center" colspan="6">
                            Нет товаров
                        </td>
                    </tr>
                    @endforelse 
                @endforeach
            @else
            @php $products = $oneCategory->products; @endphp
            @forelse ($products as $product)
                <tr>                
                    <td class="text-center">{{ $product->id }}</td>
                    <td style="width: 150px;">
                        <img src="{{ asset('storage') }}/{{ $product->picture }}" class="img-thumbnail" alt="{{ $product->name }}">
                    </td>
                    <td>{{ $oneCategory->name }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>                               
                </tr>
            @empty
            <tr>
                <td class="text-center" colspan="6">
                    Нет товаров
                </td>
            </tr>
            @endforelse
            @endif       
        </tbody>
    </table>
</div>
@endsection