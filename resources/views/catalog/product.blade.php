@extends('layouts.main')

@section('content')
    <div id="product-detail-card">
        <h1>{{ $product->name }}</h1>
        <div class=" row main">
            <div class="gallery col-md-6 col-12">
                <div class="big-carousel">
                    @foreach ($product->images as $image)
                        <a href="{{ config('catalog.product.img_path') . $image->path }}">
                            <img src="{{ config('catalog.product.img_path') . $image->path }}" alt="detail-image">
                        </a>
                    @endforeach
                </div>
                @if (count($product->images) > 2)
                    <div class="small-carousel">
                        @foreach ($product->images as $image)
                            <img src="{{ config('catalog.product.preview_path') . $image->path }}" alt="carousel-img">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="info col-md-6 col-12">
                <div class="stock">В НАЛИЧИИ</div>
                <div class="buy">
                    <div class="prices">
                        @if ($product->discount or $product->new_price)
                            <div class="old-price">{{ $product->price }}</div>
                        @endif
                        <div class="main-price"> {{ $product->getActualPrice() }} ₽</div>
                    </div>

                    <div class="add-to-card">
                        <div class="counter">
                            <div class="minus unselectable" onclick="Cart.minus({{ $product->id }})">-</div>
                            <div class="quantity unselectable" data-id="{{ $product->id }}">1</div>
                            <div class="plus unselectable" onclick="Cart.plus({{ $product->id }})">+</div>
                        </div>
                        <div class="add2cart" onclick="Cart.addToCart({{ $product->id }})" data-id="{{ $product->id }}">
                            В корзину
                        </div>
                    </div>
                </div>

                <div class="properties">

                </div>
            </div>
        </div>
        <h2 class="descHeader">Описание:</h2>
        <div class="description">
            {!! $product->description ? $product->description : 'Описание отсутствует' !!}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.big-carousel').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button" style=""><div class="inner">🠒</div></button>',
                nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button" style=""><div class="inner">🠐</div></button>',
                arrows: true,
                fade: true,
                asNavFor: '.small-carousel'
            });
            $('.small-carousel').slick({
                slidesToShow: 3,
                slidesToScroll: 3,
                asNavFor: '.big-carousel',
                arrows: false,
                centerMode: true,
                focusOnSelect: true
            });

            $('.big-carousel a').simpleLightbox({
                /* options */ });
        })
    </script>
@endsection
