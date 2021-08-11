@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.index') }}" class="btn btn-link disabled back-button col-1">
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

    <form action="{{ route('admin.menu.create') }}" method="POST" id="create-menu-form" class="col-6">
        @csrf
        @method('POST')
        <legend>Создание меню</legend>

        <label class="form-label" >Название</label>
        <input class="form-control" id="name-input" type="text" name="name" value="{{ old('name') }}">

        <label class="form-label ">Код</label>
        <input class="form-control mb-1" id="url-input" type="text" name="code" value="{{ old('code') }}">

        <h5 class="mt-3">Пункты меню: </h5>
        <div class="labels">
            <label class="form-label">Имя</label>
            <label class="form-label">Ссылка</label>
        </div>
        <div id="menu-items">
            <div class="inputs">
                <input name="name_0" type="text" class="form-control form-control-sm" value="">
                <input name="link_0" type="text" class="form-control form-control-sm" value="">
            </div>
        </div>

        <button type="button" class="btn btn-light btn-sm mt-4" id="addInput">
            Добавить еще один пункт
        </button>
        <br>
        <button type="submit" class="btn-lg btn btn-primary" style="margin-top:20px;">Создать меню</button>
    </form>

    <script>
        translitBind('name-input', 'url-input');

        let LINK_INPUT_INDEX = 1;
        $('#addInput').click(function(e) {
            let item = $('<div class="inputs">' +
                '<input name="name_' + LINK_INPUT_INDEX + '" type="text" class="form-control form-control-sm"> ' +
                '<input name="link_' + LINK_INPUT_INDEX + '" type="text" class="form-control form-control-sm"> ' +
                '</div>');
           
            $("#menu-items").append(item);
            LINK_INPUT_INDEX++
        })
    </script>
@endsection
