@extends('admin.layouts.main')

@section('content')
        <h3 style="margin-bottom:25px;">Список страниц</h3>
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Активность</th>
                </tr>
            </thead>
            <tbody>
        @foreach ($pages as $page)
                <tr>
                    <th scope="row"> {{ $page->id }}</th>
                    <td><a class="link-primary" href="{{ route('admin.page.edit') . '/' . $page->id }}">{{ $page->name }}</a></td>
                    <td> {{ $page->trashed() ? 'Нет' : 'Да'}}</td>
                </tr>
        @endforeach
            </tbody>
        </table>
@endsection