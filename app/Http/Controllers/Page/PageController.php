<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ProductService;
use Breadcrumb;
use Seo;

class PageController extends Controller
{
    public function index() {
        $page =  Page::where('code', '/' . request()->path())->firstOrFail();
        Breadcrumb::push($page->name, $page->code);

        Seo::setDescription($page->seo_description);
        Seo::setKeywords($page->seo_keywords);
        Seo::setTitle($page->name);

        return view('pages.page', [
            'page' => $page,
        ]);
    }

    public function mainPage(ProductService $productService)
    {
        return view('pages.mainpage', [
            'products' => $productService->getMainPageProducts(),
        ]);
    }
}
