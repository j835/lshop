@extends('layouts.email')

@section('content')
    <h2>Вами был сделан заказ на сайте <a href="{{ route('login') }}">gadgets-world.ru</h2>

    <h3>Заказ № {{ $order->id }}</h3>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Наименование</th>
                <th scope="col">Цена</th>
                <th scope="col">Количество</th>
                <th scope="col">Всего</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <th scope="row">
                        {{ $loop->index + 1 }}
                    </th>
                    <td>
                        {{ $product->product_name }}
                    </td>
                    <td> {{ $product->product_price }}</td>
                    <td style="text-align: center"> {{ $product->product_quantity }}</td>
                    <td>
                        {{ $product->product_price * $product->product_quantity }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align: end">Всего: {{ $order->total }}</h4>
    <br>
    
    Подробную информацию о заказе вы можете посмотреть в <a href="{{ route('profile.orders') }}">Личном кабенете</a>

    <h4>Менеджер свяжется с вами в ближайшее время</h4>
@endsection
