<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Seo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    public function index() {
        Seo::setTitle('Управление сайтом');
        return view('admin.index');
    }
}
