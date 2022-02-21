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
            <label class="form-label">Текущий пароль</label>
            <input type="password" name="current_password" class="form_control">
        </div>        
        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input type="password" name="password" class="form_control">
        </div>        
        <div class="mb-3">
            <label class="form-label">Подтвердите новый пароль</label>
            <input type="password" name="password_confirmation" class="form_control">
        </div>
        <div class="mb-3" id="addresses">
            <label class="form-label">Список адресов</label>
                @if (session('addrCanNotBeDelete'))
                <div class="alert alert-success">
                    Нельзя удалить адрес на который уже есть заказы
                </div>
                @endif
                @forelse ($user->addresses as $address)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="setAsDefault" value="{{ $address->id }}" @if ($address->main) checked @endif>
                            <label class="form-check-label" for="setAsDefault">@if ($address->main) <b> @endif  {{ $address->address }} @if ($address->main) (основной)</b> @endif </label>
                        <div class="form-check">
                            <input class="form-check-input" @if ($address->orders->count()) disabled @endif type="checkbox" value="{{ $address->id }}" name="addressesToDelete[]">
                            <label class="form-check-label" for="addressesToDelete[]">Удалить</label>
                        </div>  
                        </div>
                @empty 
                    <em>Список пуст</em>
                @endforelse
        </div> 
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input name="new_address" class="form-control"><br>
            <input class="form-check-input" type="checkbox" name="newAddrToMain">
            <label class="form-check-label" for="newAddrToMain">Сделать основным</label>
        </div> 
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
@endsection