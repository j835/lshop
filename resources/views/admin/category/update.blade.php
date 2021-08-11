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

    @if (!$category)
        <div class="alert alert-dismissible fatal-error">Ошибка:категория не найдена</div>
    @else
        <form class="col-6" method="POST" action="{{ route('admin.category.update', ['id' => $category->id]) }}"
            enctype="multipart/form-data" id="category-edit-form">
            @csrf
            @method("POST")
            <h4>Редактирование категории</h4>
            <label class="form-label no-margin">ID</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $category->id }}" name="id">

            <label class="form-label no-margin">Активность</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input"
                value="{{ $category->trashed() ? 'Нет' : 'Да' }}">

            <label class="form-label ">Имя<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('name') is-invalid @enderror" name="name" id="iname"
                value="{{ old('name') ? old('name') : $category->name }}">

            <label class="form-label">Код URL<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('code') is-invalid @enderror" name="code" id="icode"
                value="{{ old('code') ? old('code') : $category->code }}">

            <label class="form-label ">Сортировка<i>*</i></label>
            <input type="text" class="form-control mb-2 @error('sort') is-invalid @enderror" name="sort"
                value="{{ old('sort') ? old('sort') : $category->sort }}">

            <label class="form-label ">Родительская категория<i>*</i></label>

            <div class="form-group category-id-group" style="display: flex;height:40px;">
                <input type="text" readonly="" class="form-control-plaintext readonly-input" id="category-name"
                    value="{{ $category->parentCategory ? $category->parentCategory->name : 'Верхний уровень' }}">

                <input type="hidden" class="form-control" name="parent_id" id="category-id-input"
                    value="{{ $category->parent_id }}" readonly="">
                <a target="_blank" href="#categoryCategorySelect" rel="modal:open" class="btn btn-primary">Выбор
                    категории</a>
            </div>

            <label class="form-label mt-2">Скидка (на все товары категории, %)</label>
            <input type="text" class="form-control mb-2 @error('discount') is-invalid @enderror" name="discount"
                value="{{ old('discount') ? old('discount') : $category->discount }}">

            @if (!$category->image)
                <label class="form-label mt-2">Изображение категории</label>
                <input class="form-control" type="file" name="image">
            @endif


            <label class="form-label mt-2">SEO description</label>
            <textarea name="seo_description" class="form-control @error('seo_description') is-invalid @enderror" rows="2">
                {{ old('seo_description') ? old('seo_description') : $category->seo_description }}
            </textarea>

            <label class="form-label mt-2">SEO keywords</label>
            <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror" name="seo_keywords"
                value="{{ old('seo_keywords') ? old('seo_keywords') : $category->seo_keywords }}">

            <button type="submit" class="btn btn-primary mt-4">Сохранить изменения</button>
        </form>

        <div class="col-2 category-edit-filler"></div>

        <div class="category-actions col-4">
            <h4>Действия</h4>
            <form action="{{ route('admin.category.update', ['id' => $category->id]) }}" class="mb-3"  id="category-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <input type="hidden" value="{{ $category->id }}" name="id">
                <button type="submit" class="btn btn-danger">Удалить категорию</button>
            </form>

            @if ($category->trashed())
                <form action="{{ route('admin.category.activate') }}" method="POST" class="light-border-bottom pb-3">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <button type="submit" class="btn btn-large btn-primary">Активировать категорию</button>
                </form>
            @else
                <form action="{{ route('admin.category.deactivate') }}" method="POST" class="light-border-bottom pb-3">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ $category->id }}">
                    <button type="submit" class="btn btn-large btn-primary">Деактивировать категорию</button>
                </form>
            @endif

            <div class="user-orders mt-4 light-border-bottom pb-3">
                <h5>Товары категории</h5>
                <a target="_blank" class="tlink"
                    href="{{ route('admin.product.select', ['category_id' => $category->id]) }}">
                    Список товаров категории
                </a> 
            </div>

            @if($category->image) 
                <h4 class="mt-3">Изображение категории</h4>
                <div class="card border-primary mb-3 col-6">
                    <div class="card-header">
                        <form method="POST" action="{{ route('admin.category.image_delete') }}"
                            class="delete-image-form">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $category->id }}">
                            <button type="submit" class="btn btn-danger" style="width: 100%">Удалить</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <a href="{{ $category->getImagePath() }}">
                            <img src="{{ $category->getImagePath() }}" style="max-width: 100%;border-radius:5px;">
                        </a>
                    </div>
                </div>
            @endif
        </div>

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

            $('.card-body a').simpleLightbox();
            translitBind('iname', 'icode');
            formSubmitConfirm('category-delete-form', 'Вы действительно хотите удалить категорию? Восстановление невозможно');
        </script>

    @endif
@endsection
