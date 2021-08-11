<?php


namespace App\Services;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Mail\OrderCreatedManager;
use App\Mail\OrderCreatedUser;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\Facades\CartService;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class OrderService
{

    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function makeOrder(CreateOrderRequest $request)
    {
        $total = $this->cartService->getTotal();
        $cart = $this->cartService->getFullInfo();

        if(!count($cart)) {
           throw new Exception('Ошибка - пустая корзина');
        }

        $order = Order::create ([
            'user_id' => auth()->user()->id,
            'total' => $total,
            'message' => $request->message,
        ]);

        foreach($cart as $product) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_quantity' => $product->quantity,

            ]);
        }

        return $order;
    }


    public function sendClientOrderEmail($order_id) 
    {
        $email = Order::with('user')->find($order_id)->user->email;
        Mail::to($email)->send(new OrderCreatedUser($order_id));
    }

    public function sendManagerOrderEmail($order_id) 
    {
        Mail::to(config('mail.manager'))->send(new OrderCreatedManager($order_id));
    }

}