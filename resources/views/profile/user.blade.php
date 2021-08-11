@extends('layouts.main')

@section('content')
    <h1>Личный кабинет</h1>
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="error-message">{{$error}}</div>
        @endforeach
    @endif
    @if(session('success'))
        <div class="success-message">{{session('success')}}</div>
    @endif
    <div action="" id="profile-user-form" method="POST">
        <div class="label">Дата регистрации</div>
        <div class="data">{{ $user->created_at }}</div>

        <div class="label">ФИО</div>
        <div class="data">{{ $user->name }}</div>

        <div class="label">E-mail</div>
        <div class="data">{{ $user->email }}</div>

        <div class="label">Телефон</div>
        <div class="data">{{ $user->phone }}</div>

        <div class="label">Заказов</div>
        <div class="data">{{ $user->orders->count() }}</div>

    </div>
@endsection
