@extends('admin.layouts.main')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <h4>Создание группы</h4>
    <form action="{{ route('admin.role.create') }}" id="role-edit" method="POST" class="col-8">
        @csrf
        <label class="form-label mb-2 mt-2">Название</label>
        <input id="iname" class="form-control  @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}">

        <label class="form-label mb-2 mt-2">Код</label>
        <input id="icode" class="form-control  @error('code') is-invalid @enderror" type="text" name="code" value="{{ old('code') }}">

        
        <h4 class="mt-3 mb-3">Права</h4>
        <div class="permissions">
            @foreach (App\Models\Permission::all() as $permission)
                <div class="form-switch form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="{{ $permission->code }}">
                        <span class="unselectable">{{ $permission->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-lg btn-primary mt-4">Создать</button>
    </form>

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
        addHeader('Заказы',20);
        addHeader('Разное',23);

        translitBind(document.querySelector('#iname'), document.querySelector('#icode'));
    </script>
@endsection
