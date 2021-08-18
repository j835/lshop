<?php


namespace App\Services\Facades;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Category;
use Validator;


class MenuService
{
    public function get($code) 
    {
        return cache()->rememberForever('_menu.' . $code, function() use ($code) {
            $menu = Menu::with('items')->where('code', $code)->first();
            if(!$menu) {
                return [];
            } else {
                return $menu->items;
            }
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

    public function clearCacheByCode($code) 
    {
        cache()->forget('_menu.' . $code);
    }

    public function clearCacheById($id)
    {
        $menu = Menu::find($id);
        $this->clearCacheByCode($menu->code);
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


    public static function getCatalogMenuString()
    {
        return cache()->rememberForever('catalog_menu', function () {
            function printCategories($parent_id = 0)
            {
                if ($parent_id == 0) {
                    $menu = '<div class="catalog-menu">';
                } else {
                    $menu = '';
                }
                $categories = Category::where('parent_id', $parent_id)->get();

                foreach ($categories as $category) {
                    $link = '/catalog/' . $category->getAttribute('full_code') . '/';
                    $name = $category->getAttribute('name');
                    $id = $category->getKey();

                    $menu .= "<div class='category'><a data-id='$id' href='$link'>$name</a>";

                    if ($arrowFlag = Category::where('parent_id', $id)->count()) {
                        $menu .= '<div class="submenu">';
                        $menu .= printCategories($id);
                        $menu .= '</div>';
                    }

                    if ($arrowFlag) {
                        $menu .= '<div class="arrow"></div>';
                    }
                    $menu .= '</div>';
                }
                if ($parent_id == 0) {
                    $menu .= '</div>';
                }
                return $menu;
            }

            return printCategories();
        });
    } 

}