@extends('admin.layouts.main')

@section('content')

    <a href="{{ route('admin.product.index') }}" class="btn btn-link disabled back-button col-1">
        ← Назад</a>
    <div class="col-11"></div>

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

    <form action="{{ '/' . request()->path() . '/edit' }}" method="POST" id="product-edit" class="col-7">
        @csrf
        @method('POST')
        <legend>Редактирование товара</legend>

        <label class="form-label no-margin">ID</label>
        <input type="text" readonly="" class="form-control-plaintext no-padding" value="{{ $product->id }}">


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
        <input type="text" class="form-control" name="category_id"
            value="{{ (old('category_id') ? old('category_id') : $product->category_id) ? $product->category_id : '' }}">

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
                <form action="{{ '/' . request()->path() . '/unsoftdelete' }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-large btn-primary">Активировать товар</button>
                </form>
            @else
                <form action="{{ '/' . request()->path() . '/softdelete' }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-large btn-primary">Деактивировать товар</button>
                </form>
            @endif

            <form action="{{ '/' . request()->path() . '/delete' }}" id="productDeleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-large btn-danger">Удалить товар</button>
            </form>
        </div>
        <div class="row" id="product-images">
            <h4>Добавить изображения</h4>
            <form action="{{'/' . request()->path() . '/image/add'}}" class="add-image-form" method="POST" type="multipart/form-data">
                @csrf
                <div class="form-group image-inputs">
                    <input class="form-control" type="file" name="image_0">
                </div>
                <button type="button" class="btn btn-light btn-sm" id="moreImg">Добавить еще одно изображение</button><br>
                <button type="submit" class="btn btn-primary btn-large">Добавить</button>
            </form>

            <h4>Изображения</h4>
            @if (count($product->images))
                @foreach ($product->images->sortByDesc('is_main') as $image)
                    <div class="card border-primary mb-3 col-5">
                        <div class="card-header">
                            <form action="{{'/' . request()->path() . '/image/delete'}}" class="delete-image-form">
                                @csrf
                                <input type="hidden" name="img_id" value="{{ $image->id }}">
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                            @if(!$image->is_main)
                                
                                <form action="{{'/' . request()->path() . '/image/changemain'}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="img_id" value="{{ $image->id }}">
                                    <button type="submit" class="btn btn-primary">Сделать главным</button>  
                                </form>
                            @else
                                <div style="height:35px;line-height:35px;color:white;text-align:center;" class="bg-primary">
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
                    @if($loop->index % 2 == 0)
                    <div class="col-1"></div>
                    @endif
                @endforeach
            @else
                 <div clas="no-images">Изображения отсутствуют</div>       
            @endif
        </div>
    </div>


    <script src="/js/admin/productEdit.js"></script>
@endsection
