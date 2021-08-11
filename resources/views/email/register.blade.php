@component('mail::message')
    <h4>Вы были зарегестрированы на сайте <a href="{{ route('login') }}">gadgets-world.ru</h4>
    Данные для входа: <br>
    Логин: <b>{{$email}}</b> <br>
    Пароль: <b>{{ $password}}</b> <br>
    
@endcomponent