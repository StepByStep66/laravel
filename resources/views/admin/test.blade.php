@extends('layouts.app')

@section('content')
    <h1>{{ $title }}</h1>
@if ($number > 5)
    Ваше число больше 5
@else
    Ваше число меньше или равно 5
@endif

<ul>
@for ($i = 0; $i < 10; $i++)
        <li>
            {{ $i }}
        </li>
@endfor    
    </ul>

<ul>
    @foreach ($numbers as $number)
    <li> 
        @if ($loop->first)
        <b>
        @endif
        {{ $number }}
        @if ($loop->first)
        </b>
        @endif
    </li>
    @endforeach
</ul>

@endsection