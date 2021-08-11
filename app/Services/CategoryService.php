<?php


namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Category;

class CategoryService
{

    public static function getBreadcrumbCategories($array) 
    {
        return  Category::where(function ($query) use ($array) {
            foreach ($array as $code) {
                $query->orWhere('code', $code);
            }
        })->orderBy('level', 'asc')->get();
    }

    public function addImage($id, $image) 
    {
        $photo = Image::make($image)->encode('jpg', 100);
        $name = time() . '_' . md5($photo->__toString()) . '.jpg';

        Storage::put(config('storage.category_img') . $name, $photo->__toString());

        Category::withTrashed()->find($id)->update([
            'image' => $name,
        ]);
    }

    public function deleteImage($id) 
    {
        $category = Category::withTrashed()->find($id);
        
        Storage::delete(config('storage.category_img') . $category->image);

        $category->update([
            'image' => null,
        ]);

    }
    
    /**
     *  Удаляет категорию
     */

    public function deleteCategory($id) 
    {
        $category = Category::findOrFail($id);
        $this->deleteImage($id);
        $category->forceDelete();
    }


    public function updateFullCodes() 
    {
        if(!function_exists('fcRecursion')) 
        {
            function fcRecursion($base_code, $parent_id, &$categories) 
            {
                $parentCategories = $categories->where('parent_id', $parent_id);
                if(!$parentCategories->count()) {
                    return true;
                }

                foreach($parentCategories as $category) {
                    $full_code = $base_code == '' ? $category->code : $base_code . '/' . $category->code;
                    $category->update(['full_code' => $full_code]);
                    fcRecursion($full_code, $category->id, $categories);
                }
            }
        }

        Category::query()->update(['full_code' => '']);

        $categories = Category::all();
        fcRecursion('', 0, $categories);
    
        $this->deleteCatalogMenuCache();
    }

    public function deleteCatalogMenuCache() 
    {
        cache()->forget('catalog_menu');
    }


}
