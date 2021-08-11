<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CatalogService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Seo;


class CatalogController extends Controller
{

    private $service;

    public function __construct(CatalogService $service)
    {
        $this->service = $service;
    }

    public function index($code, Request $request)
    {

        $this->service->route($code);
        $this->service->formBreadcrumb();

        switch ($this->service->route_result) {
            case CatalogService::PRODUCT:
                return $this->product();
            case CatalogService::CATEGORY:
                return $this->category();
            case CatalogService::CATEGORIES_LIST:
                return $this->categoriesList();

            default:
                abort(404);
                return false;
        }
    }

    private function product()
    {
        Seo::setDescription($this->service->product->getSeoDescription());
        Seo::setKeywords($this->service->product->getSeoKeywords());
        Seo::setTitle($this->service->product->getAttribute('name'));

        return view('catalog.product', [
            'product' => $this->service->product,
        ]);
    }

    public function category()
    {
        Seo::setDescription($this->service->category->getAttribute('seo_description'));
        Seo::setKeywords($this->service->category->getAttribute('seo_keywords'));
        Seo::setTitle($this->service->category->getAttribute('name'));

        return view('catalog.category', [
            'category' => $this->service->category,
        ]);

    }

    public function categoriesList()
    {
        Seo::setDescription($this->service->category->getAttribute('seo_description'));
        Seo::setKeywords($this->service->category->getAttribute('seo_keywords'));
        Seo::setTitle($this->service->category->getAttribute('name'));

        return view('catalog.categories_list', [
            'category' => $this->service->category,
        ]);
    }

}
