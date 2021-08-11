<?php


namespace App\Services\Facades;

use App\Models\Menu;
use App\Models\MenuItem;
use Validator;

class MenuService
{
    public function get($code) 
    {
        return cache()->rememberForever('_menu.' . $code, function() use ($code) {
            return Menu::with('items')->where('code', $code)->firstOrFail()->items;
        });
    }

    public function getById($id) 
    {
        return Menu::with('items')->find($id);
    }

    public function updateMenuItem($index, $request) 
    {
        $id = $request->get('id_' . $index);

        $data = [];
        $data['name'] = $request->get('name_' . $index);
        $data['link'] = $request->get('link_' . $index);
        $data['sort'] = $request->get('sort_' . $index);
        
        if(!$this->validateItem($data)) {
            return false;
        }

        $item = MenuItem::find($id);
        $item->update($data);
        
    }


    public function addMenuItem($index, $menu_id , $request) 
    {
        $data = [];

        $data['name'] = $request->get('name_' . $index);
        $data['link'] = $request->get('link_' . $index);
        $data['sort'] = $request->get('sort_' . $index) === null ? $index : $request->get('sort_' . $index);
        $data['menu_id'] = $menu_id;

        if(!$this->validateItem($data)) {
            return false;
        }
    
        $item = new MenuItem($data);
        $item->save();

        return true;
    }

    private function validateItem($data) 
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'link' => 'required|max:255',
            'sort' => 'required|integer',
        ]);
        

       return $validator->passes();
    } 

}