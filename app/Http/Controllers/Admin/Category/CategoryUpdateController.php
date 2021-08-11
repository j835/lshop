<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use DB;
use Illuminate\Http\Request;

class CategoryUpdateController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index($id)
    {
        $this->authorize('category.get');

        return view('admin.category.update', [
            'category' => Category::withTrashed()->with('parentCategory')->find($id),
        ]);
    }

    public function update($id, UpdateCategoryRequest $request)
    {
        $this->authorize('category.update');

        DB::beginTransaction();

        Category::withTrashed()->findOrFail($id)->update($request->validated());

        if ($request->image) {
            $request->validate(['image' => 'image|max:5000']);
            $this->categoryService->addImage($id, $request->image);
        }

        $this->categoryService->updateFullCodes();
        
        DB::commit();

        return back()->with('success', 'Категория успешно обновлена');
    }

    public function delete($id, CategoryDeleteRequest $request)
    { 
        $this->authorize('category.delete');

        $this->categoryService->deleteCategory($id);
        $this->categoryService->updateFullCodes();

        return redirect(route('admin.category.select'))->with('success', 'Категория успешно удалена');
    }

    public function activate(Request $request)
    {
        $this->authorize('category.update');

        Category::withTrashed()->findOrFail($request->id)->restore();
        $this->categoryService->updateFullCodes();

        return back()->with('success', 'Категория успешно активирована');
    }

    public function deactivate(Request $request)
    {
        $this->authorize('category.update');

        Category::withTrashed()->findOrFail($request->id)->delete();
        $this->categoryService->updateFullCodes();

        return back()->with('success', 'Категория успешно деактивирована');
    }

    public function image_delete(Request $request)
    {
        $this->authorize('category.update');

        $this->categoryService->deleteImage($request->id);

        return back()->with('success', 'Изображение успешно удалено');
    }

}
