@extends('layouts.main')

@section('content')
    <div id="cart-page">
        <h1 @auth class="first" @endauth>Корзина</h1>

        @if(count($cart))

        <div class="cart-products">
            <? $total = 0 ?>
            @foreach ($cart as $item)
                <div class="order-cart-product">
                    <div class="image-wrapper">
                        <img src="{{ $item->preview_path }}" alt="{{ $item->name }}">
                    </div>
                    <div class="cart-product-info">
                        <a class="cart-product-name" href="{{ $item->path }}" target="_blank">
                            {{ $item->name }}
                        </a>
                        <div class="cart-product-cost">
                            {{ $item->price }} * {{ $item->quantity }} = <span>{{ $item->total }} ₽</span>
                            <? $total += $item->total ?>
                        </div>
                    </div>
                    <div class="cart-delete unselectable" data-id="{{ $item->id }}" 
                        onclick="Cart.delete({{$item->id}}).then(() => window.location.href = window.location.href)">
                        x
                    </div>
                </div>
            @endforeach
            <div class="cart-total">
                Всего: <span>{{ $total }} ₽</span>
            </div>
            <a class="submit" href="{{ route('order.index') }}">Перейти к оформлению заказа</a>
        </div>

        @else 

        <h3 style="margin-left: 20px;">Корзина пуста</h3>

        @endif
    </div>
@endsection
