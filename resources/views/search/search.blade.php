@extends('layouts.main')

@section('content')
    <div id="category">
        @if (count($products))
            @foreach ($products as $product)
                <div class="category-item">
                    <div class="image-wrapper">
                        <a href="{{ $product->getFullLink() }}">
                            <img src="{{ $product->getMainImagePreviewPath() }}" alt="{{ $product->name }}"></a>
                    </div>

                    <div class="item-name">
                        <a href="{{ $product->getFullLink() }}">{{ $product->name }}</a>
                    </div>
                    <div class="prices">
                        @if ($product->new_price or $product->discount or $product->category->discount)
                            <div class="old-price">{{ $product->price }}</div>
                        @endif
                        <div class="main-price">{{ $product->getActualPrice() }}</div>
                    </div>
                    <div class="item-buttons">
                        <div class="counter">
                            <div class="minus unselectable" onclick="Cart.minus({{ $product->id }})">-</div>
                            <div class="quantity unselectable" data-id="{{ $product->id }}">1</div>
                            <div class="plus unselectable" onclick="Cart.plus({{ $product->id }})">+</div>
                        </div>
                        <div class="add2cart unselectable" onclick="Cart.addToCart({{ $product->id }})"
                            data-id="{{ $product->id }}">
                            В корзину
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <h2>Товаров по запросу не найдено</h2>
        @endif

    </div>
@endsection
