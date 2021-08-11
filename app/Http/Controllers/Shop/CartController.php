<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\Facades\CartService;
use Breadcrumb;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        Breadcrumb::push('Корзина','cart');

        return view('profile.cart', [
            'cart' => $this->cartService->getFullInfo(),
        ]);
    }

    public function ajaxGetCart()
    {
        return view('templates.cart', [
            'items' => $this->cartService->getFullInfo(),
        ]);
    }

    public function ajaxAddProduct(Request $request)
    {
        try {
            $this->cartService->push($request->product_id, $request->quantity);
            return response()->json(['success' => true], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    public function ajaxDeleteProduct(Request $request)
    {
        try {
            $this->cartService->delete($request->product_id);
            return response()->json(['success' => true], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

}
