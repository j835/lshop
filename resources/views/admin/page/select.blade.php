@extends('admin.layouts.main')

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    <h3 style="margin-bottom:25px;">Список страниц</h3>
    <table class="table table-hover" id="search-result-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">URL</th>
                <th scope="col">Активность</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <th scope="row">{{ $page->id }}</th>
                    <td style="width: 30%">{{ $page->name }}</td>
                    <td style="width: 30%"> {{$page->code}}</td>
                    <td> {{ $page->trashed() ? 'Нет' : 'Да' }}</td>
                    <td style="padding-bottom:0;">
                        <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.page.update', ['id' => $page->id]) }}">
                            Редактировать <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
