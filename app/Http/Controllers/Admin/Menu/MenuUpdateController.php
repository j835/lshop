<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Facades\Menu as Menu;
use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use DB;
use Illuminate\Http\Request;

class MenuUpdateController extends Controller
{
 
    public function index($id) 
    {
        return view('admin.menu.update', [
            'menu' => Menu::getById($id),
        ]);
    }

    public function updateItems(Request $request) 
    {
        $this->authorize('category.get');

        for($i = 0; true; $i++) {
            if($request->get('id_' . $i)){
                Menu::updateMenuItem($i, $request);
            } else {
                break;
            }
        }

        return back()->with('success', 'Поля меню успешно обновлены');
    }

    public function addItems(Request $request)
    {
        $this->authorize('category.get');

        DB::beginTransaction();
        
        for($i = 0; true; $i++) {
            if($request->get('name_' . $i)){
                Menu::addMenuItem($i, $request->menu_id , $request);
            } else {
                break;
            }
        }

        DB::commit();
        
        return back()->with('success', $i + 1 . ' поля меню успешно добавлены');
    }


    public function delete($id) 
    {
        $this->authorize('category.get');

        $menu = Menu::getById($id);
        $menu->delete();

        return redirect(route('admin.menu.select'))->with('success', 'Меню успешно удалено');
    }
    
    public function deleteItem(Request $request) 
    {
        $this->authorize('category.get');

        $item = MenuItem::find($request->id);
        $item->delete();

        return back()->with('success', 'Пункт меню успешно удален');
    }
}

