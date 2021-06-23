<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCreateController extends Controller
{
    
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return view('admin.product.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'max:255',
            'code' => 'required|code|max:255|unique:catalog_products',
            'sort' => 'integer|min:1',
            'category_id' => 'integer|min:1',
            'price' => 'price',
            'discount' => 'nullable|integer|between:1,100',
            'new_price' => 'nullable|price',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ]);

        DB::beginTransaction();

        $product = Product::create($request->only([
            'name', 'code', 'sort', 'description', 'category_id', 'price', 'discount', 'new_price', 'seo_description', 'seo_keywords',
        ]));

        for ($i = 0; true; $i++) {
            $input = 'image_' . $i;
            if ($request->$input) 
            {
                $request->validate([
                    $input => 'nullable|image|max:10000',
                ]);

                $this->productService->addImage($product->id, $request->$input);
            } else {
                break;
            }
        }

        DB::commit();

        return redirect(route('admin.product.edit') . '/' . $product->id)->with('success', 'Товар успешно создан');

    }

}
