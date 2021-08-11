<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategorySelectController extends Controller
{
    public function index(Request $request) {
        $this->authorize('category.get');

        $categories = Category::withTrashed();

        if($request->q) {
            $categories->where('name', 'LIKE', '%'. $request->q .'%');
        }

        return view('admin.category.select', [
            'categories' => $categories->paginate(50),
        ]);
    }
}
