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

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    @if (!$order)
        <h4 class="fatal-error alert">Заказ не найден</h4>
    @else
        <form method="POST" class="col-8">
            <h4>Информация о заказе</h4>

            <label class="form-label">ID</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $order->id }}" name="id">

            <label class="form-label">Дата заказа</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $order->created_at }}">

            <label class="form-label ">Сумма (всего)</label>
            <input type="text" readonly="" class="form-control-plaintext readonly-input" value="{{ $order->total }}">

            <label class="form-label ">Заказчик</label><br>
            <a href="{{ route('admin.user.update', ['id' => $order->user->id]) }}" class="tlink order-user-link">
                {{ $order->user->name }}
            </a><br>

            <label class="form-label  mt-2">Отменен</label><br>
            <input type="text" readonly="" class="form-control-plaintext readonly-input"
                value="{{ $order->is_cancelled ? 'Да' : 'Нет' }}">

            <h4 class="mt-4">Состав заказа</h4>
            <table class="table table-hover" id="search-result-table">
                <thead>
                    <tr>
                        <th scope="col">№</th>
                        <th scope="col">Наименование</th>
                        <th scope="col">Цена</th>
                        <th scope="col">Количество</th>
                        <th scope="col">Всего</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <th scope="row">
                                {{ $loop->index + 1 }}
                            </th>
                            <td>
                                <a target="_blank" class="tlink"
                                    href="{{ route('admin.product.update', ['id' => $product->product_id]) }}">
                                    {{ $product->product_name }}
                                </a>
                            </td>
                            <td> {{ $product->product_price }}</td>
                            <td> {{ $product->product_quantity }}</td>
                            <td>
                                {{ $product->product_price * $product->product_quantity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h4 class="order-total" style="text-align: end">Всего: {{ $order->total }}</h4>


        </form>

        <div class="order-actions col-4">
            <h4>Действия</h4>
            <form action="{{ route('admin.order.cancel') }}" method="POST" class="mb-2">
                @csrf
                <input type="hidden" value="{{ $order->id }}" name="id">
                <button type="submit" class="btn btn-primary">{{ $order->is_cancelled ? 'Возобновить заказ' : 'Отменить заказ' }}</button>
            </form>

            <form action="{{ route('admin.order.update', ['id' => $order->id]) }}" class="mb-3" id="order-delete-form"
                method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">Удалить заказ</button>
            </form>
        </div>

        <script>
            formSubmitConfirm('order-delete-form', 'Вы действительно хотите навсегда удалить заказ? Восстановление невозможно');
        </script>
    @endif
@endsection
