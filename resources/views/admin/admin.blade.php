@extends('layouts.app')

@section('title')
<title>{{ 'Админка', config('app.name', 'Laravel') }}</title>
@endsection

@section('content')

<h1>Админка</h1>
<div class="btn-group" role="group" aria-label="Basic outlined example">
  <a role="button" class="btn btn-outline-primary" href="{{ route('adminUsers') }}">Список пользователей</a>
  <a role="button" class="btn btn-outline-primary" href="{{ route('adminProducts', 0) }}">Список продуктов</a>
  <a role="button" class="btn btn-outline-primary" href="{{ route('adminCategories') }}">Список категорий</a>
</div>
@endsection