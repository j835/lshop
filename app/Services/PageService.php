<?php


namespace App\Services;

use App\Models\Page;

class PageService
{

    const CACHE_CODE = '%page_routes';

    public function getRoutes() 
    {
        return cache()->rememberForever(self::CACHE_CODE, function() {
            $codes = [];
            foreach(Page::all() as $page) {
                $codes[] = $page->code;
            }

            return $codes;
        });
    }

    public function deleteRouteCache() {
        cache()->forget(self::CACHE_CODE);
    }
}