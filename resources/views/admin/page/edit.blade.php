@extends('admin.layouts.main')

@section('content')

    <div class="row">
        <a href="{{ route('admin.page.select') }}" class="btn btn-link disabled back-button col-1">
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


    <h4>Действия</h4>
    <div id="page-actions">
        @if ($page->trashed())
            <form action="{{ route('admin.page.activate') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $page->id }}">
                <button type="submit" class="btn btn-large btn-primary">Активировать страницу</button>
            </form>
        @else
            <form action="{{ route('admin.page.deactivate') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" name="id" value="{{ $page->id }}">
                <button type="submit" class="btn btn-large btn-primary">Деактивировать страницу</button>
            </form>
        @endif

        <form action="{{ route('admin.page.delete') }}" id="pageDeleteForm" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $page->id }}">
            <button type="submit" class="btn btn-large btn-danger">Удалить страницу</button>
        </form>

    </div>

    <form action="{{ route('admin.page.edit') }}" method="POST" id="create-page-form" class="col-12">
        @csrf
        @method('POST')
        <legend>Редактирование страницы</legend>

        <label class="form-label no-margin">ID</label>
        <input type="text" name="id" readonly="" class="form-control-plaintext no-padding" value="{{ $page->id }}">

        <label class="form-label no-margin">Активность</label>
        <input type="text" readonly="" class="form-control-plaintext no-padding mb-2"
            value="{{ $page->trashed() ? 'Нет' : 'Да' }}">

        <label class="form-label">Название</label>
        <input class="form-control" id="name-input" type="text" name="name"
            value="{{ (old('name') ? old('name') : $page->name) ? $page->name : '' }}">

        <label class="form-label ">Url</label>
        <input class="form-control" id="url-input" type="text" name="code"
            value="{{ (old('code') ? old('code') : $page->code) ? $page->code : '' }}">

        <label class="form-label" style="margin-bottom:15px;">Содержимое страницы</label>
        <textarea name="content" class="form-control" id="contentTextarea" rows="12">
                            {{ (old('content') ? old('content') : $page->content) ? $page->content : '' }}
                        </textarea>

        <label class="form-label " style="margin-top:20px;">SEO description</label>
        <input class="form-control" type="text" name="seo_description"
            value="{{ (old('seo_description') ? old('seo_description') : $page->seo_description) ? $page->seo_description : '' }}">

        <label class="form-label ">SEO keywords</label>
        <input class="form-control" type="text" name="seo_keywords"
            value="{{ (old('seo_keywords') ? old('seo_keywords') : $page->seo_keywords) ? $page->seo_keywords : '' }}">

        <button type="submit" class="btn-lg btn btn-primary" style="margin-top:20px;">Сохранить изменения</button>
    </form>

    <script>
        CKEDITOR.config.width = '900';
        CKEDITOR.config.height = '400';
        CKEDITOR.replace('contentTextarea');
        translitBind(document.querySelector('#name-input'), document.querySelector('#url-input'));

        $('#pageDeleteForm').submit(function(e) {
            if(!confirm('Вы действительно хотите навсегда удалить страницу? Восстановление невозможно')) {
                e.preventDefault();
            }
        })
    </script>
@endsection
