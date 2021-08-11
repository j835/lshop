<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderUpdateController extends Controller
{
    public function index($id) 
    {
        $this->authorize('order.get');

        return view('admin.order.update', [
            'order' => Order::with(['user', 'products'])->find($id),
        ]);
    }


    public function cancel(Request $request)
    {
        $this->authorize('order.update');

        $order = Order::find($request->id);

        $order->update([
            'is_cancelled' => $order->is_cancelled ? false : true, 
        ]);

        return back()->with('success', 'Заказ успешно изменен');
    }

    public function delete($id) 
    {
        $this->authorize('order.delete');

        Order::find($id)->delete();

        return redirect(route('admin.order.select'))->with('success', 'Заказ успешно удален');
    }


}
