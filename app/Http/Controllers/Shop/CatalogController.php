<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\CatalogRouter;
use Illuminate\Http\Request;
use Seo;


class CatalogController extends Controller
{

    private $router;

    public function index($code, Request $request)
    {
        // todo - cache 
        $this->router = new CatalogRouter($request);

        $this->router->route($code);
        $this->router->formBreadcrumb();

        switch ($this->router->route_result) {
            case CatalogRouter::PRODUCT:
                return $this->product();
            case CatalogRouter::CATEGORY:
                return $this->category();
            case CatalogRouter::CATEGORIES_LIST:
                return $this->categoriesList();

            default:
                abort(404);
                return false;
        }
    }

    private function product()
    {
        Seo::setDescription($this->router->product->getSeoDescription());
        Seo::setKeywords($this->router->product->getSeoKeywords());
        Seo::setTitle($this->router->product->getAttribute('name'));

        return view('catalog.product', [
            'product' => $this->router->product,
        ]);
    }

    public function category()
    {
        Seo::setDescription($this->router->category->getAttribute('seo_description'));
        Seo::setKeywords($this->router->category->getAttribute('seo_keywords'));
        Seo::setTitle($this->router->category->getAttribute('name'));

        return view('catalog.category', [
            'category' => $this->router->category,
        ]);

    }

    public function categoriesList()
    {
        Seo::setDescription($this->router->category->getAttribute('seo_description'));
        Seo::setKeywords($this->router->category->getAttribute('seo_keywords'));
        Seo::setTitle($this->router->category->getAttribute('name'));

        return view('catalog.categories_list', [
            'category' => $this->router->category,
        ]);
    }

}
