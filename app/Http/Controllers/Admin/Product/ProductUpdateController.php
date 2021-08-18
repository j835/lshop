<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductUpdateController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = new ProductService;
    }

    
    public function index($id)
    {
        $this->authorize('product.get');

        return view('admin.product.update', [
            'product' => $this->productService->getById($id, true),
        ]);
    }


    public function update($id, UpdateProductRequest $request)
    {
        $this->authorize('product.update');

        Product::withTrashed()->find($id)->update($request->validated());

        return back()->with('success', 'Информация о товаре успешно обновлена');
    }

    public function stores($id, Request $request) 
    {
        $product = $this->productService->getById($id, true);
        $stores = Store::all();
        
        DB::beginTransaction();

        foreach($stores as $store) {
            $storeCode = $store->code;
            $quantity = $request->$storeCode;

            $product->stores()->detach($store);

            if($quantity && (int)$quantity >= 1) {
                $product->stores()->attach($store, ['quantity' => $quantity]);
            }
        }

        $this->productService->updateQuantity($product->id);

        DB::commit();

        return back()->with('success', 'Информация о количестве товара успешно обновлено');
    }

    public function deactivate(Request $request)
    {
        $this->authorize('product.update');

        Product::withTrashed()->find($request->id)->delete();

        return back()->with('success', 'Товар успешно деактивирован');
    }

    public function activate(Request $request)
    {
        $this->authorize('product.update');

        Product::withTrashed()->find($request->id)->restore();
      
        return back()->with('success', 'Товар успешно активирован');
    }

    public function delete( Request $request)
    {
        $this->authorize('product.delete');

        $product = $this->productService->getById($request->id, true);
        
        DB::beginTransaction();

        foreach($product->images as $image) {
            $this->productService->deleteImage($image->id);
        }
        
        $product->forceDelete();

        DB::commit();

        return redirect(route('admin.product.select'))->with('success' , 'Товар ' . $product->name . 'успещно удален');
    }

}
