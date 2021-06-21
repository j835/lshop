@extends('admin.layouts.main')

@section('content')
    @if (!$product)
        <div class="alert alert-danger fatal-error">
            Товар не найден
        </div>
    @else
        <div class="row">
            <a href="{{ route('admin.product.index') }}" class="btn btn-link disabled back-button col-1">
                ← Назад</a>
            <div class="col-11"></div>
        </div>

        <div id="tab-nav-wrapper">
            <div class="tab-nav active" data-tab="main-info">
                Основная информация
            </div>
            <div class="tab-nav" data-tab="product-images">
                Изображения
            </div>
            <div class="tab-nav">
                Свойства
            </div>
            <div class="tab-nav">
                Склады
            </div>
        </div>

        @if (\Session::has('success'))
            <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @endforeach
        @endif

        <div id="tabs" class="row">
            <div class="row active" id="main-info">
                <form action="{{ route('admin.product.edit') }}" method="POST" id="product-edit" class="col-7">
                    @csrf
                    @method('POST')
                    <legend>Редактирование товара</legend>

                    <label class="form-label no-margin">ID</label>
                    <input type="text" name="id" readonly="" class="form-control-plaintext no-padding" value="{{ $product->id }}">

                    <label class="form-label no-margin">Активность</label>
                    <input type="text" readonly="" class="form-control-plaintext no-padding mb-2"
                        value="{{ $product->trashed() ? 'Нет' : 'Да' }}">

                    <label class="form-label mt-1">Сортировка</label>
                    <input type="nubmer" class="form-control" name="sort"
                        value="{{ (old('sort') ? old('sort') : $product->sort) ? $product->sort : '' }}">

                    <label class="form-label mt-2">Наименование</label>
                    <input type="text" class="form-control" name="name"
                        value="{{ (old('name') ? old('name') : $product->name) ? $product->name : '' }}">

                    <label class="form-label mt-2">Код URL</label>
                    <input type="text" class="form-control" name="code"
                        value="{{ (old('code') ? old('code') : $product->code) ? $product->code : '' }}">

                    <label class="form-label mt-2">ID Категории</label>
                    <div class="form-group category-id-group">
                        <input type="text" class="form-control" name="category_id" id="category-id-input"
                            value="{{ (old('category_id') ? old('category_id') : $product->category_id) ? $product->category_id : '' }}"
                            readonly="">
                        <a href="#chooseCategory" rel="modal:open" class="btn btn-primary">Выбор категории</a>

                    </div>
                    <label for="exampleTextarea" class="form-label mt-2">Описание товара</label>
                    <textarea name="description" class="form-control" id="exampleTextarea"
                        rows="3">{{ (old('description') ? old('description') : $product->description) ? $product->description : '' }}</textarea>

                    <label class="form-label mt-2">Цена</label>
                    <input type="number" class="form-control" name="price"
                        value="{{ (old('price') ? old('price') : $product->price) ? $product->price : '' }}">

                    <label class="form-label mt-2">Скидка %</label>
                    <input type="text" class="form-control" name="discount"
                        value="{{ (old('discount') ? old('discount') : $product->discount) ? $product->discount : '' }}">

                    <label class="form-label mt-2">Новая цена</label>
                    <input type="text" class="form-control" name="new_price"
                        value="{{ (old('new_price') ? old('new_price') : $product->new_price) ? $product->new_price : '' }}">

                    <label class="form-label mt-2">SEO description</label>
                    <textarea name="seo_description" class="form-control" id="exampleTextarea" rows="2">
                                                                {{ (old('seo_description') ? old('seo_description') : $product->seo_description) ? $product->seo_description : '' }}
                                                            </textarea>

                    <label class="form-label mt-2">SEO keywords</label>
                    <input type="text" class="form-control" name="seo_keywords"
                        value="{{ (old('seo_keywords') ? old('seo_keywords') : $product->seo_keywords) ? $product->seo_keywords : '' }}">

                    <button type="submit" class="mt-4 btn btn-primary btn-lg">Сохранить изменения</button>
                </form>

                <div class="col-5">
                    <div class="row" id="product-actions">
                        <h4>Действия</h4>
                        @if ($product->trashed())
                            <form action="{{ route('admin.product.unSoftDelete') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-large btn-primary">Активировать товар</button>
                            </form>
                        @else
                            <form action="{{ route('admin.product.softDelete') }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <button type="submit" class="btn btn-large btn-primary">Деактивировать товар</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.product.delete') }}" id="productDeleteForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-large btn-danger">Удалить товар</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row" id="product-images">
                <h4>Добавить изображения</h4>
                <form action="{{ route('admin.product.image.add') }}" class="add-image-form" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="form-group image-inputs">
                        <input class="form-control" type="file" name="image_0">
                    </div>
                    <button type="button" class="btn btn-light btn-sm" id="moreImg">Добавить еще одно
                        изображение</button><br>
                    <button type="submit" class="btn btn-primary btn-large">Добавить</button>
                </form>

                <h4>Изображения</h4>
                @if (count($product->images))
                    @foreach ($product->images->sortByDesc('is_main') as $image)
                        <div class="card border-primary mb-3 col-2">
                            <div class="card-header">
                                <form method="POST" action="{{ route('admin.product.image.delete') }}"
                                    class="delete-image-form">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="img_id" value="{{ $image->id }}">
                                    <button type="submit" class="btn btn-danger">Удалить</button>
                                </form>
                                @if (!$image->is_main)
                                    <form action="{{ route('admin.product.image.changeMain') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="img_id" value="{{ $image->id }}">
                                        <button type="submit" class="btn btn-primary">Сделать главным</button>
                                    </form>
                                @else
                                    <div style="height:35px;line-height:35px;color:white;text-align:center;"
                                        class="bg-primary">
                                        Главное изображение
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <a href="{{ $image->getPath() }}">
                                    <img src="{{ $image->getPreviewPath() }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div clas="no-images">Изображения отсутствуют</div>
                @endif
            </div>
        </div>

        <script src="/js/admin/productEdit.js"></script>

    @endif
@endsection
