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
            <tr>
                <td>#</td>
                <td style="width: 150px;">Изображение</td>
                <td>Название</td>
                <td>Описание</td>
                <td class="text-center">Удалить</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td style="width: 150px;"><img src="{{ asset('storage') }}/{{ $category->picture }}" class="img-thumbnail" alt="{{ $category->name }}"></td>
                <td><a href="{{ route('category', $category->id) }}">{{$category->name}}</a></td>
                <td>{{$category->description}}</td>
                <td style="width: 150px;" class="text-center">
                    <form method="post" action="{{ route('deleteCategory') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <button type="submit" class="btn btn-danger">x</button>
                    </form>                    
                </td>
            </tr>
        @endforeach    
        </tbody>
    </table>
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