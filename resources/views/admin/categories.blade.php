@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
<div class='container'>
    <h1>Список категорий</h1>
</div>
@endsection