<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\User;
use App\Services\Facades\CartService;
use App\Services\OrderService;
use App\Services\UserService;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    protected $cartService;
    protected $userService;
    protected $orderService;

    public function __construct(CartService $cartService, OrderService $orderService, UserService $userService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->userService = $userService;
    }

    public function index()
    {
        return view('order.order', [
            'cart' => $this->cartService->getFullInfo(),
        ]);
    }

    public function create(CreateOrderRequest $request, OrderService $orderService)
    {
      
        DB::beginTransaction();

        if (!auth()->user()) 
        {
            $user = User::create($request->validated());
            Auth::login($user);

            $this->userService->sendRegisterEmail($request->email, $request->password_raw);
        }

        $order = $orderService->makeOrder($request);
        
        DB::commit();

        $orderService->sendClientOrderEmail($order->id);
        $orderService->sendManagerOrderEmail($order->id);

        $this->cartService->emptyCart();

        return redirect(route('order.success', ['id' => $order->id]));
    }

    public function success($id)
    {
        return view('order.success', [
            'order_id' => $id,
        ]);
    }

}
