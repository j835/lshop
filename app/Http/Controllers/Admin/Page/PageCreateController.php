<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class PageCreateController extends Controller
{   

    public function index() 
    {
        return view('admin.page.create');
    }

    public function create(Request $request) 
    {
        $request->validate([
            'name' => 'max:200|required',
            'code' => 'page_code|max:200|required|unique:pages',
            'seo_keywords' => 'max:255|nullable',
            'seo_description' => 'max:255|nullable',
            'content' => 'required'
        ]);

        $page = Page::create([
            'name' => $request->name,
            'code' => $request->code,
            'seo_keywords' => $request->seo_keywords,
            'seo_description' => $request->seo_description,
            'content' => $request->content,
        ]);


        $codes = [];

        foreach(Page::all() as $page) {
            $codes[] = $page->code;
        }

        file_put_contents(
            dirname($_SERVER['DOCUMENT_ROOT'], 1) . '/routes/pages.php',
            '<?php return ' . var_export($codes, true) . ';', 
        );

        return redirect(route('admin.page.edit') . '/' . $page->id);
    }

}
