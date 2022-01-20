@extends('layouts.app')

@section('title')
<title>Профиль</title>
@endsection

@section('content')
   @if ($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
                @if (!$loop->last)<br> @endif
            @endforeach
        </div>
    @endif
    <form method="post" action="{{ route('saveProfile') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="userId" value="{{ $user->id }}">
    <div class="mb-3">
        <label class="form-label">Изображение</label><br>
        <image class="rounded float-start mb-2" style="width: 100px" src="{{ asset('storage') }}/{{ $user->picture }}">
        <input type="file" name="picture" class="form-control">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Почта</label>
        <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Имя</label>
        <input name="name" value="{{ $user->name }}" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Список адресов</label>
        <ul>
            @forelse ($user->addresses as $address)
                <li @if ($address->main) class="fw-bold" @endif>
                    {{ $address->address }}</li>
            @empty 
                <em>Список пуст</em>
            @endforelse
        </ul>
    </div> 
    <div class="mb-3">
        <label class="form-label">Новый адрес</label>
        <input name="new_address" class="form-control">
    </div> 
    <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection