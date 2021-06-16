<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        if ($request->q) {
            return view('admin.product.search', [
                'products' => $this->productService->searchWithDeleted($request->q),
            ]);

        } else if ($request->category_id) {
            return view('admin.product.category_products', [
                'products' => Product::withTrashed()->where('category_id', $request->category_id)->get(),
            ]);

        } else {
            return view('admin.product.index');
        }
    }

    public function editPage($id)
    {

        return view('admin.product.edit', [
            'product' => $this->productService->getWithDeletedById($id),
        ]);
    }

    public function edit($id, Request $request)
    {

        $product = $this->productService->getWithDeletedById($id);

        $request->validate([
            'name' => 'max:255|required|',
            'code' => 'required|code|max:255|unique:catalog_products,code,' . $product->id . ',id',
            'sort' => 'integer|required|min:1',
            'category_id' => 'integer|min:1',
            'price' => 'required|price',
            'discount' => 'nullable|integer|between:1,100',
            'new_price' => 'nullable|price',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ]);

        DB::beginTransaction();

        $product->update($request->only([
            'name', 'code', 'sort','description', 'category_id', 'price', 'discount', 'new_price', 'seo_description', 'seo_keywords'
            ]));

        DB::commit();

        return back()->with('success' , 'Информация о товаре успешно обновлена');
    }

    public function softDelete($id, Request $request)
    {
        $product = $this->productService->getWithDeletedById($id);
        $product->delete();

        return back()->with('success', 'Товар успешно деактивирован');
    }

    public function unSoftDelete($id, Request $request)
    {
        $product = $this->productService->getWithDeletedById($id);
        $product->restore();

        return back()->with('success', 'Товар успешно активирован');
    }

    public function delete($id, Request $request)
    {
        echo "Удаление товара $id" ;
    }

    

    public function changeMainImage($id, Request $request) 
    {
        $img_id = $request->img_id;
        $product = $this->productService->getWithDeletedById($id);

        DB::beginTransaction();

        $product->images->where('is_main', 1)->first()->update(['is_main' => 0]);
        $product->images->where('id', $img_id)->first()->update(['is_main' => 1]);

        DB::commit();

        return back()->with('success', 'Главное изображение успешно обновлено');

    }

    public function addImages($id,Request $request) 
    {
        $product = $this->productService->getWithDeletedById($id);

        
    }

    public function deleteImage($id, Request $request) 
    {
        dd('Удаление изображения');
    }



}
