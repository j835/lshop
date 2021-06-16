@extends('layouts.main')


@section('content')
    <h1>Авторизация</h1>

    <div class="page">
        @if($errors->any())
            @foreach($errors->all() as $error)
                <div class="error-message">{{$error}}</div>
            @endforeach
        @endif
        <form action="{{route('login') }}/" method="POST" id="login-form">
            <label>
                E-mail:
                <input type="text" name="email" value="{{ old('login') }}">
            </label>
            <label>
                Пароль:
                <input type="password" name="password">
            </label>
            @if(!config('app.debug'))
                Защита от автоматического заполнения: <br>
                <div class="g-recaptcha" data-sitekey="{{ config('app.recaptcha_site_key') }}"></div>
            @endif
            @csrf
            <input type="submit" value="Войти" class="submit">
        </form>
    </div>
@endsection
