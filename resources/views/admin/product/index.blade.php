@extends('admin.layouts.main')

@section('content')
    <h3>Поиск товара по названию:</h3>
    <form action="" method="get" id="search-form" class="form">
        <input class="form-control" type="text" class="" name="q">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>

    <h3 style="margin-top:20px;">Поиск товара по категории:</h3>
    <div id="categories-dropdown-list">
        @include('catalog.menu')
    </div>

    <script>
        catalogMenu('{{ route('admin.product.index') . '/' }}')
    </script>
@endsection
