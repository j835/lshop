@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.user.select') }}" class="btn btn-link disabled back-button col-1">
            ← Назад</a>
        <div class="col-11"></div>
    </div>


    @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form class="col-6" method="POST" action="{{ route('admin.user.create') }}">
        @csrf
        @method("POST")
        <h4>Создание пользователя</h4>

        <label class="form-label ">Имя<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">

        <label class="form-label ">Email<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('email') is-invalid @enderror" name="email"
            value="{{ old('email')}}">

        <label class="form-label ">Телефон<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('phone') is-invalid @enderror" name="phone"
            value="{{ old('phone')}}">

        <label class="form-label">Пароль</label>
        <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" >

        <label class="form-label">Подтверждение пароля</label>
        <input type="text" class="form-control mb-2 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="">

        <label class="form-label">Группа пользователя</label>
        <select name="role_id" class="form-select mb-3">
            <option value="0" selected="">Без группы</option>
            @foreach (App\Models\Role::all() as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary mt-4">Создать пользователя</button>
    </form>
@endsection
