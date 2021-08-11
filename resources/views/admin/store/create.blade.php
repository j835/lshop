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

    <form action="{{ route('admin.store.create') }}" method="POST" id="create-page-form" class="col-12">
        @csrf
        @method('POST')
        <legend>Создание склада</legend>

        <label class="form-label" >Название</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name-input" type="text" name="name" value="{{ old('name') }}">

        <label class="form-label ">Код</label>
        <input class="form-control mb-1 @error('code') is-invalid @enderror" id="code-input" type="text" name="code" value="{{ old('code') }}">

        <label class="form-label ">Адрес</label>
        <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" value="{{ old('address') }}">

        <button type="submit" class="btn-lg btn btn-primary" style="margin-top:20px;">Создать склад</button>
    </form>

    <script>
        translitBind('name-input', 'code-input');
    </script>
@endsection