<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Facades\Menu as Menu;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class MenuCreateController extends Controller
{
    public function index() 
    {        
        return view('admin.menu.create');
    }

    public function create(Request $request) 
    {
        $this->authorize('menu');

        $request->validate([
            'name' => 'max:255|required',
            'code' => 'max:255|required',
        ]);

        DB::beginTransaction();

        $menu = new \App\Models\Menu($request->only('name','code'));
        $menu->save();

        for($i = 0; true; $i++) {
            if($request->get('name_' . $i) !== null) {
                Menu::addMenuItem($i, $menu->id, $request);
            } else {
                break;
            }
        }   

        DB::commit();

        return redirect(route('admin.menu.update', ['id' => $menu->id]))->with('success', 'Меню успешно создано');
    }
}
