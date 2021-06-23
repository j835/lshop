<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Seo;

class PageController extends Controller
{
    public function index() {
        $page = Page::where('code', '=', request()->path())->first();
        Seo::setDescription($page->seo_description);
        Seo::setKeywords($page->seo_keywords);
        Seo::setTitle($page->name);

        return view('page', [
            'page' => $page,
        ]);
    }
}
