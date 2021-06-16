@extends('admin.layouts.main')

@section('content')
    <a href="{{ route('admin.product.index') }}" class="btn btn-link disabled back-button col-1">
        ← Назад</a>
    <div class="col-11"></div>
    @if (count($products))
        <h4 style="margin:30px 0 10px 0;">Результаты</h4>
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Наименование</th>
                    <th scope="col">Активность</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($products as $product)
                <tr>
                    <th scope="row"> {{ $product->id }}</th>
                    <td><a class="link-primary" href="{{ route('admin.product.index') . '/' . $product->id }}">{{ $product->name }}</a></td>
                    <td> {{ $product->trashed() ? 'Нет' : 'Да'}}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
    @else
        <h3>Товаров не найдено</h3>
    @endif

@endsection
