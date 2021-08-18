<?php


namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\ProductService;
use Breadcrumb;

class CatalogRouter
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

    private $productService;
    private $categoryService;

    public $route_result = self::NOT_FOUND;


    public function __construct(Request $request) 
    {
        $this->path = str_replace(config('catalog.path') . '/', '', $request->path());
        $this->pathArray = explode('/', $this->path);

        $this->productService =  new ProductService();
        $this->categoryService = new CategoryService();
    }

    public function route($code)
    {
        if ($this->category = Category::where('full_code', $this->path)->with('subcategories', 'catalog_products')->first()) 
        {
            $this->route_result = $this->category->subcategories()->count() ? self::CATEGORIES_LIST : self::CATEGORY;

        } else {
            $pathArray = $this->pathArray;
            $this->product = $this->productService->getByCode(array_pop($pathArray));

            if ($this->product && $this->product->category->full_code === join('/', $pathArray)) 
            {
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

        $categories = Category::where(function ($query) use ($pathArray) {
            foreach ($pathArray as $code) {
                $query->orWhere('code', $code);
            }
        })->orderBy('level', 'asc')->get();

        foreach ($categories as $category) {
            Breadcrumb::push($category->getAttribute('name'), $category->getAttribute('code'));
        }

        if ($this->product) {
            Breadcrumb::push($this->product->getAttribute('name'), $this->product->getAttribute('code'));
        }
    }

}