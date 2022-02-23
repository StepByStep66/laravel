@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class="container">
<h1>Список категорий</h1>
<div class="table-responsive">
    @if (session('canNotDeleteCategory'))
        <div class="alert alert-warning text-center">
            Нельзя удалить категорию в которой есть товары
        </div>
    @endif
    <table class="table table-bordered align-middle">
        <thead>
            <th>#</th>
            <th style="width: 150px;">Изображение</th>
            <th>Название</th>
            <th>Описание</th>
            <th class="text-center">Удалить</th>

        </thead>
        <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td style="width: 150px;"><img src="{{ asset('storage') }}/{{ $category->picture }}" class="img-thumbnail" alt="{{ $category->name }}"></td>
                <td><a href="{{ route('category', $category->id) }}">{{$category->name}}</a></td>
                <td>{{ Str::limit($category->description, 200, ' (...)') }}</td>
                <td style="width: 150px;" class="text-center">
                    <form method="post" action="{{ route('deleteCategory') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <button type="submit" class="btn btn-danger" @if ($category->products->count()) disabled @endif>x</button>
                    </form>                    
                </td>
            </tr>
        @endforeach    
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
            Добавить категорию
        </a>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="post" action="{{ route('addCategory') }}" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Изображение</label><br>
                    <input type="file" name="picture" class="form-control mb-3" placeholder="Изображение"> 
                    <input class="form-control mb-3" name="name" placeholder="Название"> 
                    <textarea class="form-control mb-3" name="description" placeholder="Описание"></textarea> 
                    <button class="btn btn-success" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    </div>
</div>
    @if (session('startExportCategories'))
    <div class="alert alert-success">
        Выгрузка категорий запущена
    </div>
    @endif
    <form method="post" action="{{ route('exportCategories') }}">
        @csrf
        <button type="submit" class="btn btn-link">Выгрузить категории</button>
    </form>
</div>
@endsection