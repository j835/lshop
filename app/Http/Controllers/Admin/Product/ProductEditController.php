<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductEditController extends Controller
{

    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->q) 
        {
            return view('admin.product.search', [
                'products' => $this->service->searchWithDeleted($request->q),
            ]);
        }  
        
        if ($request->category_id) 
        {
            return view('admin.product.category_products', [
                'products' => Product::withTrashed()->where('category_id', $request->category_id)->get(),
            ]);
        }
         
        return view('admin.product.index');
    }

    public function editPage($id)
    {
        return view('admin.product.edit', [
            'product' => $this->service->getWithDeletedById($id),
        ]);
    }


    public function edit( Request $request)
    {

        $product = $this->service->getWithDeletedById($request->id);

        $request->validate([
            'name' => 'max:255',
            'code' => 'code|max:255|unique:catalog_products,code,' . $product->id . ',id',
            'sort' => 'integer|min:1',
            'category_id' => 'integer|min:1',
            'price' => 'price',
            'discount' => 'nullable|integer|between:1,100',
            'new_price' => 'nullable|price',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ]);

        DB::beginTransaction();

        $product->update($request->only([
            'name', 'code', 'sort', 'description', 'category_id', 'price', 'discount', 'new_price', 'seo_description', 'seo_keywords',
        ]));

        DB::commit();

        return back()->with('success', 'Информация о товаре успешно обновлена');
    }

    public function deactivate(Request $request)
    {
        $product = Product::withTrashed()->find($request->id);
        $product->delete();

        return back()->with('success', 'Товар успешно деактивирован');
    }

    public function activate(Request $request)
    {
        $product = Product::withTrashed()->find($request->id);
        $product->restore();

        return back()->with('success', 'Товар успешно активирован');
    }

    public function delete( Request $request)
    {
        $product = $this->service->getWithDeletedById($request->id);
        
        DB::beginTransaction();

        foreach($product->images as $image) {
            $this->service->deleteImage($image->id);
        }
        
        $product->forceDelete();

        DB::commit();

        return redirect(route('admin.product.index'))->with('success' , 'Товар ' . $product->name . 'успещно удален');

    }

}
