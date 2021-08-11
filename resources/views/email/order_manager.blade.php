@extends('layouts.email')

@section('content')
<h2>Новый заказ на сайте <a href="{{ route('admin.index') }}">gadgets-world.ru</h2>
    
    Подробную информацию о заказе вы можете посмотреть в <a href="{{ route('admin.order.update', ['id' => $order->id ]) }}">панели администратора</a>

    <h3>Информация о покупателе</h3>
    
    Имя: {{ $order->user->name}} <br>
    E-mail: {{ $order->user->email}} <br>
    Телефон: {{ $order->user->phone}} <br>
    Сообщение: {{ $order->message}} <br>

    <h3>Заказ № {{ $order->id }} от {{ $order->created_at }}</h3>

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
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $product->product_name }}</td>
                    <td> {{ $product->product_price }}</td>
                    <td style="text-align: center"> {{ $product->product_quantity }}</td>
                    <td>{{ $product->product_price * $product->product_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="text-align: end">Всего: {{ $order->total }}</h4>

    @endsection
