<?php

namespace App\Http\Controllers\Admin\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreSelectController extends Controller
{
    public function index() {
        return view('admin.store.select', [
            'stores' => Store::all(),
        ]);
    }
}
