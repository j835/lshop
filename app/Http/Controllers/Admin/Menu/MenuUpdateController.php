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

    public function update(Request $request) 
    {
        $request->validate([
            'name' => 'max:255|required',
            'code' => 'code|required',
        ]);

        $menu = Menu::getById($request->id);
        $menu->update($request->only(['name', 'code']));

        Menu::clearCacheByCode($menu->code);

        return back()->with('success', 'Меню успешно обновлено');
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

        Menu::clearCacheById($request->menu_id);

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
        
        Menu::clearCacheById($request->menu_id);

        return back()->with('success', $i + 1 . ' поля меню успешно добавлены');
    }


    public function delete($id) 
    {
        $this->authorize('category.get');

        $menu = Menu::getById($id);
        Menu::clearCacheByCode($menu->code);

        $menu->delete();

        return redirect(route('admin.menu.select'))->with('success', 'Меню успешно удалено');
    }
    
    public function deleteItem(Request $request) 
    {
        $this->authorize('category.get');

        $item = MenuItem::find($request->id);
        $item->delete();

        Menu::clearCacheById($request->menu_id);

        return back()->with('success', 'Пункт меню успешно удален');
    }


}

