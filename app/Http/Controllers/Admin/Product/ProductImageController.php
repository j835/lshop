<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductImageController extends Controller
{
    
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function changeMain(Request $request)
    {
        $product = $this->productService->getWithDeletedById($request->product_id);

        DB::beginTransaction();

        $product->images->where('is_main', 1)->first()->update(['is_main' => 0]);
        $product->images->where('id', $request->img_id)->first()->update(['is_main' => 1]);

        DB::commit();

        return back()->with('success', 'Главное изображение успешно обновлено');
    }

    public function add(Request $request)
    {
        $images = $request->except(['_token', 'product_id']);

        DB::beginTransaction();

        foreach ($images as $key => $image) {
            $request->validate([$key => 'image|max:10000']);
            $this->productService->addImage($request->product_id, $image);
        }

        DB::commit();

        return back()->with('success', 'Изображения успешно добавлены');
    }

    public function delete(Request $request)
    {
        $this->productService->deleteImage($request->img_id);
        return back()->with('success', 'Изображение успешно удалено');
    }

}
