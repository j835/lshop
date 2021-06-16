@extends('layouts.main')


@section('content')

    <form action="/register" method="POST" class="rform">
        @csrf
        <label>
            Имя
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{$message}}</div>
            @enderror
        </label>
        <label>
            Email
            <input type="text" name="email" value="{{ old('email') }}">
            @error('email')
            <div class="error">{{$message}}</div>
            @enderror
        </label>
        <label>
            Телефон
            <input type="text" name="phone" value="{{ old('phone') }}">
            @error('phone')
            <div class="error">{{$message}}</div>
            @enderror
        </label>
        <label>
            Пароль
            <input type="password" name="password" value="{{ old('password') }}">
            @error('password')
            <div class="error">{{$message}}</div>
            @enderror
        </label>
        <label>
            Повторите пароль
            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">

        </label>
        <input type="submit" value="Регистрация">
    </form>

    <style>

        .rform input {
            display: block;
            margin-top:10px;
            height: 30px;
            font-size: 16px;
            padding:5px;
            margin-bottom:10px;
            min-width: 250px;
        }

        .error {
            color:red;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
@endsection
