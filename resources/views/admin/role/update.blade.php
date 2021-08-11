@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.role.select') }}" class="btn btn-link disabled back-button col-1">
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

    @if (!$role)
        <h4 class="fatal-error alert">Группа не найдена</h4>
    @else
        <h4>Управление группой</h4>
        <form action="{{ route('admin.role.update', ['id' => $role->id]) }}" id="role-edit" method="POST" class="col-8">
            @csrf
            <label class="form-label no-margin">ID</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $role->id }}" name="id">

            <label class="form-label mb-2 mt-2">Название</label>
            <input id="iname" class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                value="{{ old('name') ? old('name') : $role->name }}">

            <label class="form-label mb-2 mt-2">Код</label>
            <input id="icode" class="form-control @error('code') is-invalid @enderror" type="text" name="code"
                value="{{ old('code') ? old('code') : $role->code }}">


            <h4 class="mt-3 mb-3">Права</h4>
            <div class="permissions">
                @foreach (App\Models\Permission::all() as $permission)
                    <div class="form-switch form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="{{ $permission->code }}"
                                {{ $role->permissions->where('code', $permission->code)->count() ? 'checked' : '' }}>
                            <span class="unselectable">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-lg btn-primary mt-4">Сохранить</button>
        </form>

        <div class="role-actions col-4">
            <h4>Действия</h4>
            <form action="{{ route('admin.role.update', ['id' => $role->id]) }}" class="mb-3" id="group-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $role->id }}" name="id">
                <button type="submit" class="btn btn-danger">Удалить группу</button>
            </form>

            <a href="{{ route('admin.user.select') . '?role_id=' . $role->id }}" class="tlink"
                style="font-size: 18px">Список пользователей группы
            </a>
        </div>

        <script>
            function addHeader(text, beforeIndex) {
                let div = document.querySelectorAll('.form-switch')[beforeIndex];
                $(div).before('<h5>' + text + '<h5>');
            }

            addHeader('Товар', 0);
            addHeader('Категория', 4);
            addHeader('Пользователи', 8);
            addHeader('Группы:', 12);
            addHeader('Страницы', 16);
            addHeader('Заказы', 20);
            addHeader('Разное', 23);

            formSubmitConfirm('group-delete-form', 'Вы действительно хотите удалить группу. Восстановление невозможно');

            translitBind(document.querySelector('#iname'), document.querySelector('#icode'));
        </script>

    @endif
@endsection
