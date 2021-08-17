<?php


namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;
use Breadcrumb;

class CatalogService
{
    const PRODUCT = 'PRODUCT';
    const NOT_FOUND = 'NOT_FOUND';
    const CATEGORY = 'CATEGORY';
    const CATEGORIES_LIST = 'CATEGORIES_LIST';

    public $categories;
    public $category;
    public $product;

    private $path;
    private $pathArray;

    public $route_result = self::NOT_FOUND;

    public function __construct(Request $request) {
        $this->path = str_replace(config('catalog.path') . '/', '', $request->path());
        $this->pathArray = explode('/', $this->path);
    }

    public function route($code)
    {
        if ($this->category = Category::where('full_code', $this->path)->with('subcategories', 'catalog_products')->first()) {

            if ($this->category->getRelation('subcategories')->count()) {
                $this->route_result = self::CATEGORIES_LIST;
            } else {
                $this->route_result = self::CATEGORY;
            }
        } else {
            $pathArray = $this->pathArray;
            $this->product = ProductService::getByCode(array_pop($pathArray));

            if ($this->product && $this->product->getRelation('category')->full_code == join('/', $pathArray)) {
                $this->route_result = self::PRODUCT;
            }
        }
    }

    public function formBreadcrumb()
    {
        Breadcrumb::push('Каталог', config('catalog.path'));

        $pathArray = $this->pathArray;
        if ($this->product) {
            array_pop($pathArray);
        }

        $categories = CategoryService::getBreadcrumbCategories($pathArray);

        foreach ($categories as $category) {
            Breadcrumb::push($category->getAttribute('name'), $category->getAttribute('code'));
        }

        if ($this->product) {
            Breadcrumb::push($this->product->getAttribute('name'), $this->product->getAttribute('code'));
        }
    }


    public static function getMenuString()
    {
        return cache()->rememberForever('catalog_menu', function () {
            function printCategories($parent_id = 0)
            {
                if ($parent_id == 0) {
                    $menu = '<div class="catalog-menu">';
                } else {
                    $menu = '';
                }
                $categories = Category::where('parent_id', $parent_id)->get();

                foreach ($categories as $category) {
                    $link = '/catalog/' . $category->getAttribute('full_code') . '/';
                    $name = $category->getAttribute('name');
                    $id = $category->getKey();

                    $menu .= "<div class='category'><a data-id='$id' href='$link'>$name</a>";

                    if ($arrowFlag = Category::where('parent_id', $id)->count()) {
                        $menu .= '<div class="submenu">';
                        $menu .= printCategories($id);
                        $menu .= '</div>';
                    }

                    if ($arrowFlag) {
                        $menu .= '<div class="arrow"></div>';
                    }
                    $menu .= '</div>';
                }
                if ($parent_id == 0) {
                    $menu .= '</div>';
                }
                return $menu;
            }

            return printCategories();
        });
    } 

}
