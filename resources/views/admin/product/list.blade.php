@extends('admin.layouts.main')

@section('content')
    <a href="{{ route('admin.product.select') }}" class="btn btn-link disabled back-button col-1">
        ← Назад</a>
    <div class="col-11"></div>

    @if (\Session::has('success'))
    <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif
    
    <h4>Поиск товара по названию:</h4>
    <form action="" method="get" id="search-form" class="form">
        <input class="form-control" type="text" class="" name="q" value="{{ request()->q }}">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>


    @if ($products)
        <h4 class="mt-4 mb-2 ">
            @if (request()->category_id) Товары категории
            {{ App\Models\Category::find(request()->category_id)->name }} @else Результаты @endif
        </h4>
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Активность</th>
                    <th scole="col"> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row"> {{ $product->id }}</th>
                        <td>{{ $product->name }}</td>
                        <td> {{ $product->trashed() ? 'Нет' : 'Да' }}</td>
                        <td style="padding-bottom:0;">
                            <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.product.update', ['id' => $product->id]) }}">
                                Редактировать <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h3>Товаров не найдено</h3>
    @endif

@endsection
