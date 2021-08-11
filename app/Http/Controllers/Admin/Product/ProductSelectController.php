<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductSelectController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $this->authorize('product.get');
    
        if ($request->q) 
        {
            return view('admin.product.list', [
                'products' => $this->productService->search($request->q, true),
            ]);
        }  
        
        if ($request->category_id) 
        {
            return view('admin.product.list', [
                'products' => Product::withTrashed()->where('category_id', $request->category_id)->get(),
            ]);
        }
         
        return view('admin.product.index');
    }
}
