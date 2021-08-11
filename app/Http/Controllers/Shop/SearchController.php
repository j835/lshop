<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;

class SearchController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request) {
        return view('search.search', [
            'products' => $this->productService->search($request->q)
        ]);
    }

    public function ajaxQuickSearch(Request $request) {
        $products = $this->productService->search($request->q, false, 5);
        $return = [];
        foreach($products as $product) {
            $return[] = [
                'name' => $product->name,
                'link' => $product->getFullLink(),
            ];
        }

        return response()->json($return, 200);
    }
}
