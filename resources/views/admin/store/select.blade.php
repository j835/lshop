@extends('admin.layouts.main')

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    <h3 style="margin-bottom:25px;">Список складов</h3>
    <table class="table table-hover" id="search-result-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Адрес</th>
                <th scope="col">Активность</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stores as $store)
                <tr>
                    <th scope="row">{{ $store->id }}</th>
                    <td style="width: 30%">{{ $store->name }}</td>
                    <td style="width: 30%"> {{$store->address}}</td>
                    <td> {{ $store->trashed() ? 'Нет' : 'Да' }}</td>
                    <td style="padding-bottom:0;">
                        <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.store.update', ['id' => $store->id]) }}">
                            Редактировать <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
