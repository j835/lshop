<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderSelectController extends Controller
{
    public function index(Request $request) 
    {   
        $this->authorize('order.get');

        $orders = Order::with('user');

        if($request->user_id) {
            $orders->where('user_id', $request->user_id);
        }

        return view('admin.order.select', [
            'orders' => $orders->paginate(50),
        ]);
    }
}
