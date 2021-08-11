<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreCreateController extends Controller
{
    public function index()
    {
        return view('admin.store.create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'max:255|required',
            'code' => 'code|max:255|required|unique:stores',
            'address' => 'required|max:255',
        ]);
 
        $store = new Store($request->only('name', 'code', 'address'));
        $store->save();

        return redirect(route('admin.store.update', ['id' => $store->id]))->with('success', 'Склад успешно создан');
    }
}
