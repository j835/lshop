<?php


namespace App\Http\Controllers;
use App\Facades\Breadcrumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use Cart;

class PagesController
{

    public function test(Request $request) {
        dd(session()->all());
    }

}
