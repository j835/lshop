<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\ProductService;
use Illuminate\Http\Request;

class StoreUpdateController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index($id) 
    {
        $this->authorize('store.get');

        return view('admin.store.update', [
            'store' => Store::withTrashed()->find($id),
        ]);    
    }

    public function update(Request $request) 
    {
        $request->validate([
            'name' => 'max:255|required',
            'code' => 'code|max:255|required|unique:stores,code,' . $request->id . ',id',
            'address' => 'required|max:255',
        ]);

        $store = Store::find($request->id);
        $store->update($request->only('name', 'code', 'address'));

        return back()->with('success', 'Информация о складе успешно обновлена');
    }

    public function activate(Request $request) 
    {
        $this->authorize('store.update');
    
        Store::withTrashed()->find($request->id)->restore();
        $this->productService->updateAllProductsQuantity();

        return back()->with('success', 'Склад успешно активирован');

    }


    public function deactivate(Request $request) 
    {
        $this->authorize('store.update');

        Store::withTrashed()->find($request->id)->delete();
        $this->productService->updateAllProductsQuantity();

        return back()->with('success', 'Склад успешно деактивирован');
    }

    public function delete(Request $request) 
    {
        $this->authorize('store.delete');
        
        Store::withTrashed()->find($request->id)->forceDelete();
        $this->productService->updateAllProductsQuantity();
        
        return redirect(route('admin.store.select'))->with('success', 'Склад успешно удален');
    }
}
