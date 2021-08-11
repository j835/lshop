@extends('admin.layouts.main')

@section('content')

    @if (\Session::has('success'))
    <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    <a href="{{ route('admin.role.create') }}" class="role-create tlink no-padding" style="font-size: 26px;">
        Создать новую группу
    </a>
    
    <h4 style="margin-bottom:25px;margin-top:25px;padding:0px;">Группы пользователей</h4>
    <table class="table table-hover" id="search-result-table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Название</th>
                <th scope="col">Число пользователей</th>
                <th scope="col">Пользователи группы</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
       
    @foreach ($roles as $role)
            <tr>
                <th style="width:10%" scope="row" class="id tlink">{{ $role->id }}</th>
                <td style="width:30%"> {{ $role->name }}</td>
                <td style="width:20%;"> {{ $role->users->count() }}</td>
                <td > 
                    <a class="tlink" href="{{ route('admin.user.select', ['role_id' => $role->id]) }}">Список пользователей</a>
                </td>
                <td style="padding-bottom:0;">
                    <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.role.update', ['id' => $role->id]) }}">
                        Редактировать <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>
@endsection
