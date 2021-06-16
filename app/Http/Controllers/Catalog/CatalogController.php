<?php

namespace App\Http\Controllers\Catalog;


use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Services\CatalogService;
use Faker\Provider\Image as ProviderImage;
use Illuminate\Http\Request;
use Seo;
use Storage;
use Illuminate\Http\File;
use Intervention\Image\Facades\Image;

class CatalogController extends Controller
{

    private $service;

    public function __construct(CatalogService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {

        $this->service->route();

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
            'product' => $this->service->product
        ]);
    }


    public function category()
    {
        Seo::setDescription($this->service->category->getAttribute('seo_description'));
        Seo::setKeywords($this->service->category->getAttribute('seo_keywords'));
        Seo::setTitle($this->service->category->getAttribute('name'));

        return view('catalog.category', [
            'category' => $this->service->category
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



    public function test() 
    {
   
        $images = ProductImage::all();
        foreach($images as $image) {
            $newName = time() . '_' . $image->path;
            
            Storage::putFileAs('public/product',
             new File($_SERVER['DOCUMENT_ROOT'] . '/upload/catalog/product/' . $image->path),
             $newName);
            
            Storage::putFileAs('/public/product_preview',
             new File($_SERVER['DOCUMENT_ROOT']  . '/upload/catalog/product_preview/' . $image->preview_path),
             $newName);
            
             $image->update(['path' => $newName]);
        
        }
    }
}
