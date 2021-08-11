@extends('admin.layouts.main')

@section('content')

    <div class="row">
        <a href="{{ route('admin.store.select') }}" class="btn btn-link disabled back-button col-1">
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


    <form action="{{ route('admin.store.update', ['id' => $store->id]) }}" method="POST" id="create-page-form" class="col-6">
        @csrf
        @method('POST')
        <legend>Редактирование склада</legend>

        <label class="form-label no-margin">ID</label>
        <input type="text" name="id" readonly="" class="form-control-plaintext no-padding" value="{{ $store->id }}">

        <label class="form-label no-margin">Активность</label>
        <input type="text" readonly="" class="form-control-plaintext no-padding mb-2 "
            value="{{ $store->trashed() ? 'Нет' : 'Да' }}">

        <label class="form-label">Название</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name-input" type="text" name="name"
            value="{{ old('name') ? old('name') : $store->name }}">

        <label class="form-label ">Url</label>
        <input class="form-control no-margin @error('code') is-invalid @enderror" id="url-input" type="text" name="code"
            value="{{ old('code') ? old('code') : $store->code}}">
        <br>

        <label class="form-label ">Адрес</label>
        <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" 
            value="{{ old('address') ? old('address') : $store->address }}">

        <button type="submit" class="btn-lg btn btn-primary" style="margin-top:20px;">Сохранить изменения</button>
    </form>

    <div class="col-2 filler"></div>

        <div class="user-actions col-4">

            <h4>Действия</h4>

            <form action="{{ route('admin.store.delete', ['id' => $store->id]) }}" class="mb-3"  id="store-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $store->id }}" name="id">
                <button type="submit" class="btn btn-danger">Удалить склад</button>
            </form>

            @if ($store->trashed())
                <form action="{{ route('admin.store.activate') }}" method="POST" class="light-border-bottom pb-3">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $store->id }}">
                    <button type="submit" class="btn btn-large btn-primary">Активировать склад</button>
                </form>
            @else
                <form action="{{ route('admin.store.deactivate') }}" method="POST" class="light-border-bottom pb-3">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $store->id }}">
                    <button type="submit" class="btn btn-large btn-primary">Деактивировать склад</button>
                </form>
            @endif
        </div>

    <script>
        translitBind('name-input','url-input');
        formSubmitConfirm('store-delete-form', 'Вы действительно хотите навсегда удалить склад и информацию о наличии товаров в нем?');
    </script>
@endsection
