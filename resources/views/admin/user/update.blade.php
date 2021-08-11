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
            <div class="alert  alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (!$user)
        <div class="alert alert-dismissible fatal-error">Ошибка:пользователь не найден</div>
    @else

        <form class="col-6" method="POST" action="{{ route('admin.user.update', ['id' => $user->id]) }}">
            @csrf
            @method("POST")
            <h4>Информация о пользователе</h4>
            <label class="form-label no-margin">ID</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $user->id }}" name="id">

            <label class="form-label ">Имя<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') ? old('name') : $user->name }}">

            <label class="form-label ">Email<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') ? old('email') : $user->email }}">

            <label class="form-label ">Телефон<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('phone') is-invalid @enderror" name="phone"
                value="{{ old('phone') ? old('phone') : $user->phone }}">

            <label class="form-label">Новый пароль </label>
            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}">

            <label class="form-label">Подтверждение пароля</label>
            <input type="text" class="form-control mb-2 @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="">

            <label class="form-label">Группа пользователя</label>
            <select name="role_id" class="form-select">
                <option value="0" {{ $user->role_id == 0 ? 'selected' : '' }}>Без группы</option>
                @foreach (App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}</option>
                @endforeach
            </select>
            @if ($user->role_id != 0)
                <small class="form-text text-muted input-hint">
                    <a class="tlink" href="{{ route('admin.role.update', ['id' => $user->role_id]) }}">Информация о
                        группе</a>
                </small><br>
            @endif

            <label class="form-label mt-3">Дата регистрации</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $user->created_at }}">

            <button type="submit" class="btn btn-primary mt-4">Обновить информацию о пользователе</button>
        </form>


        <div class="col-2 filler"></div>

        <div class="user-actions col-4">
            <h4>Действия</h4>
            <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" class="mb-3" id="user-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $user->id }}" name="id">
                <button type="submit" class="btn btn-danger">Удалить пользователя</button>
            </form>

            <form action="{{ route('admin.user.login') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $user->id }}" name="id">
                <button type="submit" class="btn btn-primary">Авторизоваться</button>
            </form>

            <div class="user-orders mt-4">
                <h5>Заказы пользователя - {{ $user->orders->count() }}</h5>
                <a target="_blank" class="tlink" href="{{ route('admin.order.select') . '?user_id=' . $user->id }}">
                    Список заказов пользователя
                </a>
            </div>
        </div>
        
        <script>
            formSubmitConfirm('user-delete-form', 'Вы действительно хотите удалить пользователя? Восстановление невозможно');
        </script>

    @endif
@endsection
