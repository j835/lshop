<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index() {
        return view('profile.index');
    }


    public function user() {
        return view('profile.user', [
            'user' => auth()->user(),
        ]);
    }

    public function updateUser(Request $request, UserService $userService) {
        $userService->updateUserInfo($request);
        return back()->with('success','Личные данные успешно обновлены');
    }


    public function orders() {
        return view('profile.orders', [
            'orders' => auth()->user()->orders()->get(),
        ]);
    }




    public function order($id) {
        return view('profile.order' , [
            'order' => auth()->user()->orders()->with('products')->find($id),
        ]);
    }

    public function cancelOrder($id) {
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
