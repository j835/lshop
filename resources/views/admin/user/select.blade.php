@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <a href="{{ route('admin.user.select') }}" class="btn btn-link disabled back-button col-1">
            ← Назад</a>
        <div class="col-11"></div>
    </div>

    @if (\Session::has('success'))
    <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
    @endif

    <h5 class="no-padding">Поиск:</h5>
    <form action="" method="get" id="search-form" class="form">
        <input class="form-control" type="text" class="" name="q" value="{{ request()->q }}"
            placeholder="поиск по имени/email/телефону">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>
    <h5 class="mt-2 no-padding">Фильтр по группе</h5>
    <form action="" method="get" class="form mt-1" id="group-filter-form">
        <select name="role_id" id="" class="form-select" >
            <option value="0">Без группы</option>
            @foreach (App\Models\Role::all() as $role)
                <option value="{{ $role->id}}" @if(request()->role_id == $role->id) selected @endif>{{$role->name}}</option>
            @endforeach
        </select>
        <button class="btn btn-primary" ><i class="fas fa-search"></i></button>
    </form>
    <h4 style="margin-bottom:25px;margin-top:25px;padding:0px;">
        Список пользователей @if(request()->role_id) группы "{{ App\Models\Role::find(request()->role_id)->name}}" @endif
    </h4>

    @if (!$users->count())
        <div class="fatal-error alert">Пользователей не найдено</div>
    @else
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Email</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Группа</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row"> {{ $user->id }}</a></th>
                        <td> {{ $user->name }}</td>
                        <td> {{ $user->email }}</td>
                        <td> {{ $user->phone }}</td>
                        <td> {{ $user->role ? $user->role->name : 'Без группы' }}</td>
                        <td style="padding-bottom:0;">
                            <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.user.update', ['id' => $user->id]) }}">
                                Подробно <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links('pagination::bootstrap-4') }}

    @endif
@endsection
