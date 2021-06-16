<?php


namespace App\Http\Controllers\Catalog;
use Illuminate\Support\Facades\Auth;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController
{

    public function createOrderPage() {
        $cart = Cart::getFullInfo();
        return view('catalog.order', [
            'cart' => $cart
        ]);
    }


    public function create(Request $request, UserService $userService) {

        if(!Auth::id()) {
            $user_id = $userService->orderRegister($request);
        } else {
            $user_id = Auth::id();
        }

        $total = Cart::getTotal();
        $cart = Cart::getFullInfo();

        if(!count($cart)) {
           return  back()->withErrors(['empty_cart' => 'Ошибка - пустая корзина']);
        }

        DB::beginTransaction();
        try {
            $order = Order::create ([
                'user_id' => $user_id,
                'total' => $total,
            ]);

            foreach($cart as $product) {
                OrderProduct::create([
                    'order_id' => $order->getAttribute('id'),
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_quantity' => $product->quantity,

                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            return back()->with(['exception' => $e->getMessage()]);
        }


        Cart::emptyCart();
        return $this->orderSuccessPage($order->getAttribute('id'));
    }

    private function orderSuccessPage($order_id) {
        return view('catalog.order_success', [
            'order_id' => $order_id,
        ]);
    }



}
