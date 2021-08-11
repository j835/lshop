@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.menu.select') }}" class="btn btn-link disabled back-button col-1">
            ← Назад</a>
        <div class="col-11"></div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    @if (!$menu)
        <div class=" alert fatal-error">Ошибка: меню не найдено</div>
    @else
        <div class="col-6">
            <h4>Основная информация</h4>
            <form action="" id="update-menu-form" method="POST" class="mb-2">
                @csrf
                <label class="form-label no-margin">ID</label>
                <input type="text" name="id" readonly="" class="form-control-plaintext no-padding"
                    value="{{ $menu->id }}">

                <label class="form-label no-margin">Название меню</label>
                <input class="form-control mt-2 mb-2" id="name-input" type="text" name="name"
                    value="{{ (old('name') ? old('name') : $menu->name) ? $menu->name : '' }}">

                <label class="form-label">Код</label>
                <input class="form-control mt-2 mb-2" id="code-input" type="text" name="code"
                    value="{{ (old('code') ? old('code') : $menu->code) ? $menu->code : '' }}">

                <button type="submit" class="btn btn-primary mt-3">Обновить основную информацию</button>
            </form>

            <h4 class="mt-4 mb-2">Пункты меню</h4>
            @if ($menu->items->count())
                <form id="update-menu-items" class="mb-2" method="POST" action="{{ route('admin.menu.update_items') }}">
                    @csrf
                    <div class="labels">
                        <label class="form-label">Имя</label>
                        <label class="form-label">Ссылка</label>
                        <label class="form-label sort">Сортировка</label>
                    </div>
                    @foreach ($menu->items as $item)
                        <input type="hidden" readonly="" class="form-control" name="{{ 'id_' . $loop->index }}"
                            value="{{ $item->id }}">
                        <div class="inputs">
                            <input name="{{ 'name_' . $loop->index }}" type="text" class="form-control form-control-sm"
                                value="{{ $item->name }}">
                            <input name="{{ 'link_' . $loop->index }}" type="text" class="form-control form-control-sm"
                                value="{{ $item->link }}">
                            <input name="{{ 'sort_' . $loop->index }}" type="text"
                                class="form-control form-control-sm sort" value="{{ $item->sort }}">
                            <button class="btn btn-sm" id="menuItemDeleteButton" type="button"
                                onclick="deleteMenuItem({{ $item->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-3">Обновить пункты меню</button>
                </form>
                <form action="{{ route('admin.menu.delete_item') }}" method="POST" class="hidden"
                    id="menuItemDeleteForm">
                    @csrf
                    <input type="text" name="id" value="">
                </form>
            @else
                <div class="col-12">Пункты меню отсутствуют</div>
            @endif

            <h4 class="mt-4 mb-2">Добавление новых пунктов</h4>
            <form action="{{ route('admin.menu.add_items') }}" method="POST" id="add-menu-items">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <div class="labels">
                    <label class="form-label">Имя</label>
                    <label class="form-label">Ссылка</label>
                    <label class="form-label sort">Сортировка</label>
                </div>

                <div id="menu-items">
                    <div class="inputs">
                        <input name="name_0" type="text" class="form-control form-control-sm" value="">
                        <input name="link_0" type="text" class="form-control form-control-sm" value="">
                        <input name="sort_0" type="text" class="form-control form-control-sm sort" value="">
                    </div>
                </div>

                <button type="button" class="btn btn-light btn-sm mt-3" id="addInput">
                    Добавить еще один пункт
                </button>
                <br>
                <button type="submit" class="btn btn-primary mt-3">
                    Добавить пункты
                </button>
            </form>
        </div>

        <div class="col-2 filler"></div>

        <div class="user-actions col-4">
            <h4>Действия</h4>
            <form action="{{ route('admin.menu.delete', ['id' => $menu->id]) }}" class="mb-3" id="menu-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $menu->id }}" name="id">
                <button type="submit" class="btn btn-danger">Удалить меню</button>
            </form>

        </div>

        <script>
            function deleteMenuItem(id) {
                $('#menuItemDeleteForm input[name=id]').val(id);
                if (confirm('Удалить пункт меню?')) {
                    $('#menuItemDeleteForm').submit();
                }
            }

            formSubmitConfirm('menu-delete-form', 'Вы действительно хотите удалить меню? Восстановление невозможно');


            let LINK_INPUT_INDEX = 1;
            $('#addInput').click(function() {
                let item = $('<div class="inputs">' +
                    '<input name="name_' + LINK_INPUT_INDEX +
                    '" type="text" class="form-control form-control-sm"> ' +
                    '<input name="link_' + LINK_INPUT_INDEX +
                    '" type="text" class="form-control form-control-sm"> ' +
                    '<input name="sort_' + LINK_INPUT_INDEX +
                    '" type="text" class="form-control form-control-sm sort"> ' +
                    '</div>');

                $("#menu-items").append(item);
                LINK_INPUT_INDEX++
            })
        </script>

    @endif
@endsection
