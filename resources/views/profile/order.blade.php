@extends('layouts.main')

@section('content')
    @if(!$order)
        <div class="error-message">Заказ не найден</div>
    @else
        <h1>Информация о заказе</h1>

        @if($order->is_cancelled)
            <div class="error-message">Заказ отменен</div>
        @endif
        <div id="profile-order">
            <h2>Информация о заказе:</h2>

            <div class="order-date">
                ID заказа: <span>{{ $order->id }}</span><br>
                Дата создания: <span>{{ $order->created_at }}</span><br>
                Статус заказа: <span>Заказ принят</span><br>
            </div>
            <h2>Состав заказа:</h2>
            @foreach($order->products as $product)
                <div class="order-product">
                    <span class="index">{{$loop->index + 1}}</span>. <span
                        class="name">{{$product->product_name}}</span> <br>
                    <div class="cost">
                        <span class="price">{{$product->product_price}} * {{ $product->product_quantity }} = </span>&nbsp;<span
                            class="total">{{ $product->product_price * $product->product_quantity }} ₽</span>
                    </div>
                </div>
            @endforeach
            <div class="order-total">
                Всего: <span>{{ $order->total }} ₽</span>
            </div>
            @if(!$order->is_cancelled)
                <form action="" class="cancel-order" method='post'>
                    @method('DELETE')
                    @csrf
                    <input class="submit" type="submit" value="Отменить заказ">
                </form>
            @endif
        </div>

        <script>
            $('.cancel-order').submit(function(e) {
                if(!confirm('Вы уверены?')) {
                    return false
                }
            })
        </script>
    @endif
@endsection
