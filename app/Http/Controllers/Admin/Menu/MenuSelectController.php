<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuSelectController extends Controller
{
    public function index() {
        return view('admin.menu.select', [
            'menus' => Menu::all(),
        ]);
    }
}
