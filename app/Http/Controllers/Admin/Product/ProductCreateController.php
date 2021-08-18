<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCreateController extends Controller
{
    
    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }

    public function index()
    {
        $this->authorize('product.get');
        return view('admin.product.create');
    }

    public function create(CreateProductRequest $request)
    {
        $this->authorize('product.create');

        DB::beginTransaction();

        $product = Product::create($request->validated());
        
        foreach($request->all() as $key => $value) {
            if(preg_match('/^image_[0-9]+$/', $key)) 
            {
                $request->validate([$key => 'nullable|image|max:5000']);
                $this->productService->addImage($product->id, $value);
            }
        }

        DB::commit();

        return redirect(route('admin.product.update' , ['id' => $product->id]) )->with('success', 'Товар успешно создан');

    }

}
