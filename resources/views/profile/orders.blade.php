@extends('layouts.main')

@section('content')
    <h1>Мои заказы</h1>
        <div id="profile-orders">
            @if(!count($orders))
                <div class="error-message">Заказов не найдено</div>
            @else

                @foreach($orders as $order)
                    <a class="order" href="{{route('profile.orders') . '/' . $order->id}}/">
                        Заказ №{{$order->id}} от {{ $order->created_at }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @endforeach
            @endif
        </div>
@endsection
