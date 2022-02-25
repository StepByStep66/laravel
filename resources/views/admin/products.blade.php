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
                    @if (!$product)
                    <tr>
                        <td class="text-center" colspan="6">
                            Нет товаров
                        </td>
                    </tr>
                    @endif
                    @endforeach
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
@if ($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
                @if (!$loop->last)<br> @endif
            @endforeach
        </div>
@endif
    <div class="mb-5">
        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
            Добавить продукт
        </a>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="post" action="{{ route('addProduct') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Изображение</label><br>
                    <input type="file" name="addPicture" class="form-control mb-3" placeholder="Изображение"> 
                    <input class="form-control mb-3" name="addName" placeholder="Название"> 
                    <select name="addToCategory" class="form-select mb-3" aria-label="Default select example">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>   
                    <textarea class="form-control mb-3" name="addDescription" placeholder="Описание"></textarea> 
                    <input class="form-control mb-3" name="addPrice" placeholder="Цена"> 
                    <button class="btn btn-success" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection