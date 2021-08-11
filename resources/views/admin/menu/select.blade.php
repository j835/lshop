@extends('admin.layouts.main')

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    <h3 style="margin-bottom:25px;">Список меню</h3>
    <table class="table table-hover" id="search-result-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Дата создания</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menus as $menu)
                <tr>
                    <th scope="row">{{ $menu->id }}</th>
                    <td style="width: 30%">{{ $menu->name }}</td>
                    <td style="width: 30%"> {{$menu->date_created}}</td>
                    <td style="padding-bottom:0;">
                        <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.menu.update', ['id' => $menu->id]) }}">
                            Редактировать <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection