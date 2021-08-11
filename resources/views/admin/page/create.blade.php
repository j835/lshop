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


    <form action="{{ route('admin.page.create') }}" method="POST" id="create-page-form" class="col-12">
        @csrf
        @method('POST')
        <legend>Создание статичной страницы</legend>

        <label class="form-label" >Название</label>
        <input class="form-control @error('name') is-invalid @enderror" id="name-input" type="text" name="name" value="{{ old('name') }}">

        <label class="form-label ">Url</label>
        <input class="form-control mb-1 @error('code') is-invalid @enderror" id="url-input" type="text" name="code" value="{{ old('code') }}">
        <small id="emailHelp" class="form-text text-muted">Образец: "/test" , "/" в начале добавляется автоматически при необходимости</small><br>

        <label class="form-label mt-3" style="margin-bottom:15px;">Содержимое страницы</label>
        <textarea name="content" class="form-control @error('code') is-invalid @enderror" id="contentTextarea" rows="12">{{ old('content') }}</textarea>

        <label class="form-label " style="margin-top:20px;">SEO description</label>
        <input class="form-control @error('seo_description') is-invalid @enderror" type="text" name="seo_description" value="{{ old('seo_description') }}">

        <label class="form-label ">SEO keywords</label>
        <input class="form-control @error('seo_keywords') is-invalid @enderror" type="text" name="seo_keywords" value="{{ old('seo_keywords') }}">

        <button type="submit" class="btn-lg btn btn-primary" style="margin-top:20px;">Создать страницу</button>
    </form>

    <script>
        CKEDITOR.config.width = '900';
        CKEDITOR.config.height = '400';
        CKEDITOR.replace('contentTextarea');
        translitBind(document.querySelector('#name-input'), document.querySelector('#url-input'));
    </script>
@endsection