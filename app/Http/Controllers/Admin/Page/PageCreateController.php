<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\CreatePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PageCreateController extends Controller
{   

    public function __destruct()
    {
        app(PageService::class)->deleteRouteCache();
    }

    public function index() 
    {   
        $this->authorize('page.get');

        return view('admin.page.create');
    }

    public function create(CreatePageRequest $request) 
    {
        $this->authorize('page.create');

        if($request->code[0] !== '/') {
            $request->code = '/' . $request->code;
            dd($request->validated());
        }

        $page = Page::create($request->validated());

        return redirect(route('admin.page.update', ['id' => $page->id]) );
    }

}
