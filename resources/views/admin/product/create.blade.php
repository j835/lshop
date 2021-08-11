@extends('admin.layouts.main')

@section('content')

    <a href="{{ route('admin.product.select') }}" class="btn btn-link disabled back-button col-1">
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
            <input type="nubmer" class="form-control @error('sort') is-invalid @enderror" name="sort" value="{{ old('sort') ? old('sort') : 500 }}">

            <label class="form-label mt-2">Наименование</label>
            <input id="iname" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

            <label class="form-label mt-2">Код URL</label>
            <input id="icode" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}">

            <label class="form-label mt-2">Категория</label>
            <div class="form-group category-id-group">
                <input type="text" readonly="" class="form-control-plaintext readonly-input" id="category-name"
                        value="">
                <input type="hidden" class="form-control" name="category_id" id="category-id-input"
                    value="{{ old('category_id') }}" readonly="">
                <a href="#productCategorySelect" rel="modal:open" class="btn btn-primary">Выбор категории</a>

            </div>

            <label for="exampleTextarea" class="form-label mt-2">Описание товара</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="descriptionTextarea"
                rows="3">{{ old('description') }}</textarea>

            <label class="form-label mt-2">Цена</label>
            <input  class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}">

            <label class="form-label mt-2">Скидка %</label>
            <input type="text" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount') }}">

            <label class="form-label mt-2">Новая цена</label>
            <input type="text" class="form-control @error('new_price') is-invalid @enderror" name="new_price" value="{{ old('new_price') }}">

            <label class="form-label mt-2">SEO description</label>
            <textarea name="seo_description" class="form-control @error('seo_description') is-invalid @enderror"  rows="2">{{ old('seo_description') }}</textarea>

            <label class="form-label mt-2">SEO keywords</label>
            <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror" name="seo_keywords" value="{{ old('seo_keywords') }}">


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
