@extends('admin.layouts.main')

@section('content')
        <div class="row">
            <a href="{{ route('admin.order.select') }}" class="btn btn-link disabled back-button col-1">
                ← Назад</a>
            <div class="col-11"></div>
        </div>

        @if (\Session::has('success'))
        <div class="alert alert-dismissible alert-success"> {{ \Session::get('success') }}</div>
        @endif

        <h3 style="margin-bottom:25px;">Список заказов</h3>
        <table class="table table-hover" id="search-result-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Отменен</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Покупатель</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
        @foreach ($orders as $order)
                <tr>
                    <th scope="row" class="id">
                        <a href="{{ route('admin.order.update', ['id' => $order->id]) }}">{{ $order->id }}</a>
                    </th>
                    <td> {{ $order->total }}</td>
                    <td> {{ $order->is_cancelled ? 'Да' : 'Нет' }}</td>
                    <td> {{ $order->created_at }}</td>
                    <td> 
                        <a class="tlink" href="{{ route('admin.user.update', ['id' => $order->user->id]) }}"> 
                            {{ $order->user->name}} 
                        </a>
                    </td>
                    <td style="padding-bottom:0;">
                        <a class="badge rounded-pill bg-primary plink" href="{{ route('admin.order.update', ['id' => $order->id]) }}">
                            Подробно <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
        @endforeach
            </tbody>
        </table>
        {{ $orders->links('pagination::bootstrap-4') }}
@endsection