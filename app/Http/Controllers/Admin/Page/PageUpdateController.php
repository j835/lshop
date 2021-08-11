<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\Request;
use Storage;

class PageUpdateController extends Controller
{
    
    public function __destruct()
    {
        app(PageService::class)->deleteRouteCache();
    }

    public function index($id) 
    {
        $this->authorize('page.get');

        return view('admin.page.update', [
            'page' => Page::withTrashed()->find($id),
        ]);    
    }

    public function update(UpdatePageRequest $request) 
    {
        $this->authorize('page.update');

        if($request->code[0] != '/') {
            $request->code = '/' . $request->code;
    
        }

        Page::withTrashed()->find($request->id)->update($request->validated());

        return back()->with('success', 'Страница успешно изменена');   
    }

    public function activate(Request $request) 
    {
        $this->authorize('page.update');
    
        Page::withTrashed()->find($request->id)->restore();

        return back()->with('success', 'Страница успешно активирована');

    }


    public function deactivate(Request $request) 
    {
        $this->authorize('page.update');

        Page::withTrashed()->find($request->id)->delete();

        return back()->with('success', 'Страница успешно деактивирована');
    }

    public function delete(Request $request) 
    {
        $this->authorize('page.delete');
        
        Page::withTrashed()->find($request->id)->forceDelete();
        
        return redirect(route('admin.page.select'))->with('success', 'Страница успешно удалена');
    }

}
