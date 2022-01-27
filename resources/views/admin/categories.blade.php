@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class='container'>
    <h1>Список категорий</h1>
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