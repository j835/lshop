<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use DB;
use Illuminate\Http\Request;

class CateogryCreateController extends Controller
{
    public function index() 
    {
        $this->authorize('category.get');

        return view('admin.category.create');
    }

    public function create(CreateCategoryRequest $request, CategoryService $categoryService) 
    {
        $this->authorize('category.create');

        DB::beginTransaction();

        $category = Category::create($request->validated());

        if($request->image) {
            if ($request->image) {
                $request->validate(['image' => 'image|max:5000']);
                $categoryService->addImage($category->id, $request->image);
            }
        }

        $categoryService->updateFullCodes();

        DB::commit();

        return redirect(route('admin.category.update', ['id' => $category->id]))->with('success', 'Категория успешео создана');
    }
}
