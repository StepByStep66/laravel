@extends('layouts.app')

@section('title')
<title>{{ $title, config('app.name', 'Laravel') }}</title>
@endsection

@section('content')

    <h1>{{ $title }}</h1>

    <table class="table table-bordered">
        <thead>
            <th>#</th>
            <th>Имя</th>
            <th>Почта</th>
            <th>Админ</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin }}</td>
                    <td class="text-center">
                        <a href="{{ route('enterAsUser', $user->id) }}">Войти</a>                    
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection