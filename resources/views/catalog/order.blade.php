@extends('layouts.main')


@section('content')
    @if(!count($cart))
        <div class="cart-no-products">
            Корзина пуста
        </div>
    @else


        <form action="" id="order-form" method="POST">
            <h2 class="first">Информация о покупателе</h2>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="error-message">{{$error}}</div>
                @endforeach
            @endif
            <div class="buyer-info">
                <label class="label">
                    Ф.И.О <i>*</i><br>
                    <input @auth readonly @endauth type="text" name="name"
                           value="{{ Auth::user() ? Auth::user()->name : old('name') }}">
                </label>
                <label class="label">
                    E-mail <i>*</i><br>
                    <input @auth readonly @endauth type="text" name="email"
                           value="{{ Auth::user() ? Auth::user()->email : old('email')}}">
                </label>
                <label class="label">
                    Телефон <i>*</i><br>
                    <input @auth readonly @endauth type="text" name="phone"
                           value="{{Auth::user() ? Auth::user()->phone : old('phone')}}">
                </label>
                <label class="label">
                    Сообщение:<br>
                    <textarea name="message"></textarea>
                </label>
            </div>

            <h2>Заказ</h2>
            <div class="cart-products">
                <? $total = 0 ?>
                @foreach($cart as $item)
                    <div class="order-cart-product">
                        <div class="image-wrapper">
                            <img src="{{$item->preview_path}}" alt="{{$item->name}}">
                        </div>
                        <div class="cart-product-info">
                            <a class="cart-product-name" href="{{$item->path}}" target="_blank">
                                {{$item->name}}
                            </a>
                            <div class="cart-product-cost">
                                {{$item->price}} * {{$item->quantity}} = <span>{{$item->total}} ₽</span>
                                <? $total += $item->total ?>
                            </div>
                        </div>
                        <div class="cart-delete" data-id="{{$item->id}}"></div>
                    </div>
                @endforeach
                <div class="cart-total">
                    Всего: <span>{{$total}} ₽</span>
                </div>
                <input type="submit" class="submit" value="Оформить заказ">
            </div>
            @csrf
        </form>
    @endif
@endsection
