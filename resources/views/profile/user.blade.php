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
    <form action="" id="profile-user-form" method="POST">
        @csrf
        <div class="label">
            Ф.И.О <i>*</i>
            <input type="text" name="name" value="{{ $user->name }}">
        </div>
        <div class="label">
            E-mail <i>*</i>
            <input type="text" name="email" value="{{ $user->email }}">
        </div>
        <div class="label">
            Телефон <i>*</i>
            <input type="text" name="phone" value="{{ $user->phone }}">
        </div>
        <input type="submit" class="submit" value="Изменить личные данные">
    </form>
@endsection
