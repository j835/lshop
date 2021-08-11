<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\UserService;
use Breadcrumb;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        Breadcrumb::push('Личный кабинет', 'profile');
    }

    public function index()
    {
        return view('profile.index');
    }

    public function user()
    {
        Breadcrumb::push('Информация о пользователе', 'personal');

        return view('profile.user', [
            'user' => User::with('orders')->find(auth()->user()->id),
        ]);
    }

    public function orders()
    {
        Breadcrumb::push('Мои заказы', 'orders');

        return view('profile.orders', [
            'orders' => auth()->user()->orders()->get(),
        ]);
    }

    public function order($id)
    {
        Breadcrumb::push('Мои заказы', 'orders');
        Breadcrumb::push('Заказ № ' . $id, $id);

        return view('profile.order', [
            'order' => auth()->user()->orders()->with('products')->find($id),
        ]);
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::find($id);

            $this->authorize('cancel', $order);
            $order->update(['is_cancelled' => true]);

            return back();

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
