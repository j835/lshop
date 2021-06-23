<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageEditController extends Controller
{

    public function select() {
        return view('admin.page.select', [
            'pages' => Page::withTrashed()->get(),
        ]);
    }

    public function index($id) {
        return view('admin.page.edit', [
            'page' => Page::withTrashed()->find($id),
        ]);    
    }

    public function edit(Request $request) 
    {
        $request->validate([
            'name' => 'max:200|required',
            'code' => 'page_code|max:200|required|unique:pages,code,' . $request->id . ',id',
            'seo_keywords' => 'max:255|nullable',
            'seo_description' => 'max:255|nullable',
            'content' => 'required'
        ]);

        $page = Page::withTrashed()->find($request->id);

        $page->update([
            'name' => $request->name,
            'code' => $request->code,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'content' => $request->content,
        ]);

        $this->updatePagesList();

        return back()->with('success', 'Страница успешно изменена');   
    }

    public function activate(Request $request) {
        $page = Page::withTrashed()->find($request->id);
        $page->restore();
        $this->updatePagesList();

        return back()->with('success', 'Страница успешно активирована');

    }


    public function deactivate(Request $request) {
        $page = Page::withTrashed()->find($request->id);
        $page->delete();
        $this->updatePagesList();

        return back()->with('success', 'Страница успешно деактивирована');
    }

    public function delete(Request $request) {
        $page = Page::withTrashed()->find($request->id);
        $page->forceDelete();
        $this->updatePagesList();

        return redirect(route('admin.page.select'))->with('success', 'Страница успешно удалена');
    }

    private function updatePagesList() 
    {
        $codes = [];

        foreach(Page::all() as $page) {
            $codes[] = $page->code;
        }

        file_put_contents(
            dirname($_SERVER['DOCUMENT_ROOT'], 1) . '/routes/pages.php',
            '<?php return ' . var_export($codes, true) . ';', 
        );  
    }
}
