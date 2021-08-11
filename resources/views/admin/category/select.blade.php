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

    <h5 class="no-padding">Поиск:</h5>
    <form action="" method="get" id="search-form" class="form mb-4">
        <input class="form-control" type="text" class="" name="q" value="{{ request()->q }}"
            placeholder="поиск по названию категории">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
    </form>

    @if (!$categories->count())
        <div class="fatal-error alert">Категорий не найдено</div>
    @else
        <h4 class="no-padding">Категории</h4>
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Активность</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row"> {{ $category->id }}</a></th>
                        <td> {{ $category->name }}</td>
                        <td > {{ $category->trashed() ? 'Нет' : 'Да' }}</td>
                        <td style="padding-bottom:0;">
                            <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.category.update', ['id' => $category->id]) }}">
                                Подробно <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categories->links('pagination::bootstrap-4') }}

    @endif
@endsection
