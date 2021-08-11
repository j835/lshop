@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.category.select') }}" class="btn btn-link disabled back-button col-1">
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

    <form class="col-6" method="POST" action="{{ route('admin.category.create') }}" enctype="multipart/form-data"
        id="category-edit-form">
        @csrf
        @method("POST")
        <h4>Создание категории</h4>

        <label class="form-label ">Имя<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name" id="iname" value="{{ old('name') }}">

        <label class="form-label ">Код URL<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('code') is-invalid @enderror" name="code" id="icode" value="{{ old('code') }}">

        <label class="form-label ">Сортировка<i>*</i></label>
        <input type="text" class="form-control mb-2 @error('sort') is-invalid @enderror" name="sort" value="{{ old('sort') ? old('sort') : '500' }}">

        <label class="form-label ">Родительская категория<i>*</i></label>

        <div class="form-group category-id-group" style="display: flex;height:40px;">
            <input type="text" readonly="" class="form-control-plaintext readonly-input" id="category-name"
                value="Верхний уровень">

            <input type="hidden" class="form-control" name="parent_id" id="category-id-input" value="0" readonly="">
            <a target="_blank" href="#categoryCategorySelect" rel="modal:open" class="btn btn-primary">Выбор
                категории</a>
        </div>

        <label class="form-label mt-2">Скидка (на все товары категории, %)</label>
        <input type="text" class="form-control mb-2" name="discount" value="{{ old('discount') }}">


        <label class="form-label mt-2">Изображение категории</label>
        <input class="form-control " type="file" name="image">

        <label class="form-label mt-2">SEO description</label>
        <textarea name="seo_description " class="form-control @error('seo_description') is-invalid @enderror" rows="2">{{ old('seo_description') }}</textarea>

        <label class="form-label mt-2">SEO keywords</label>
        <input type="text" class="form-control  @error('seo_keywords') is-invalid @enderror" name="seo_keywords" value="{{ old('seo_keywords') }}">

        <button type="submit" class="btn btn-primary mt-4">Добавить категорию</button>
    </form>

    <script>
        $(document).ready(function() {
            let links = document.querySelectorAll('.category>a');
            for (let link of links) {
                $(link).click(function(e) {
                    e.preventDefault();
                    document.querySelector('#category-id-input').value = link.dataset.id;
                    document.querySelector('#category-name').value = link.textContent;
                    link.rel = 'modal:close';
                })
            }
        })
        translitBind('iname', 'icode');
    </script>

@endsection
