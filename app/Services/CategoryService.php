<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{

    public static function getCategoryByFullCode($code) {
        return Category::where('full_code', $code)->with('subcategories', 'products')->first();
    }

    public static function getBreadcrumbCategories($array) {

        return  Category::where(function ($query) use ($array) {
            foreach ($array as $code) {
                $query->orWhere('code', $code);
            }
        })->orderBy('level', 'asc')->get();
    }

}
