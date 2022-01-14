@extends('layouts.app')

@section('title')
<title>{{ 'Админка', config('app.name', 'Laravel') }}</title>
@endsection

@section('content')

<h1>Админка</h1>
<a href="{{ route('adminUsers') }}">Список пользователей</a><br>
<a href="{{ route('adminProducts') }}">Список продуктов</a><br>
<a href="{{ route('adminCategories') }}">Список категорий</a>

@endsection