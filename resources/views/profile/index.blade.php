@extends('layouts.main')

@section('content')
    <h1>Личный кабинет</h1>
    <div>
        <div id="profile-index" class="row">
            <a href="{{ route('profile.orders') }}/" >
                <i class="fas fa-list fa-3x"></i>
                <div>Список заказов</div>
            </a>
            <a href="{{ route('profile.user') }}/" >
                <i class="fas fa-user fa-3x"></i>
                <div>Личные данные</div>
            </a>
            <a href="{{ route('cart') }}/" >
                <i class="fas fa-shopping-cart fa-3x"></i>
                <div>Корзина</div>
            </a>
        </div>
    </div>
@endsection
