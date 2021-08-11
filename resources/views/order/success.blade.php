@extends('layouts.main')


@section('content')
    <div class="div" id="order-success">
        <img src="/img/icon/checkmark.png" alt="checkmark">
        <div class="message">
            Заказ <b>№{{$order_id}}</b> успешно создан<br>
            <p>Подробности в <a href="/profile/">Личном кабинете</a></p>
        </div>
    </div>
@endsection
