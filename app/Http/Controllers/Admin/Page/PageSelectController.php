<?php

namespace App\Http\Controllers\Admin\Page;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageSelectController extends Controller
{
    public function index() {
        $this->authorize('page.get');

        return view('admin.page.select', [
            'pages' => Page::withTrashed()->get(),
        ]);
    }
}
