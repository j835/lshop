@extends('admin.layouts.main')

@section('content')

    <a href="{{ route('admin.product.index') }}" class="btn btn-link disabled back-button col-1">
        ← Назад</a>
    <div class="col-11"></div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('admin.product.create') }}" method="POST" id="product-create" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="main-section col-7">
            <legend>Создание товара</legend>

            <label class="form-label mt-1">Сортировка</label>
            <input type="nubmer" class="form-control" name="sort" value="{{ old('sort') ? old('sort') : 500 }}">

            <label class="form-label mt-2">Наименование</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">

            <label class="form-label mt-2">Код URL</label>
            <input type="text" class="form-control" name="code" value="{{ old('code') }}">

            <label class="form-label mt-2">ID Категории</label>
            <div class="form-group category-id-group">
                <input type="text" class="form-control" name="category_id" id="category-id-input"
                    value="{{ old('category_id') }}" readonly="">
                <a href="#chooseCategory" rel="modal:open" class="btn btn-primary">Выбор категории</a>

            </div>

            <label for="exampleTextarea" class="form-label mt-2">Описание товара</label>
            <textarea name="description" class="form-control" id="descriptionTextarea"
                rows="3">{{ old('description') }}</textarea>

            <label class="form-label mt-2">Цена</label>
            <input type="number" class="form-control" name="price" value="{{ old('price') }}">

            <label class="form-label mt-2">Скидка %</label>
            <input type="text" class="form-control" name="discount" value="{{ old('discount') }}">

            <label class="form-label mt-2">Новая цена</label>
            <input type="text" class="form-control" name="new_price" value="{{ old('new_price') }}">

            <label class="form-label mt-2">SEO description</label>
            <textarea name="seo_description" class="form-control"  rows="2">{{ old('seo_description') }}</textarea>

            <label class="form-label mt-2">SEO keywords</label>
            <input type="text" class="form-control" name="seo_keywords" value="{{ old('seo_keywords') }}">


            <h5>Изображения</h5>

            <div class="form-group add-image-form">
                <div class="image-inputs">
                    <input class="form-control" type="file" name="image_0">
                </div>
                <button type="button" class="btn btn-light btn-sm" id="moreImg">Добавить еще одно изображение</button>
            </div>

            <button type="submit" class="mt-4 btn btn-primary btn-lg" style="width:175px;">Создать</button>
        </div>

        <div class="side-section col-5">


        </div>
    </form>

    <script src="/js/admin/productEdit.js"></script>
@endsection
