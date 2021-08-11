<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Http\Request;

class RoleCreateController extends Controller
{
    public function index()
    {
        $this->authorize('user.role.get');

        return view('admin.role.create');
    }

    public function create(Request $request)
    {
        $this->authorize('user.role.create');

        $request->validate([
            'name' => 'required|max:150',
            'code' => 'code|required|max:150',
        ]);

        DB::beginTransaction();

        $role = new Role($request->only(['name', 'code']));
        $role->save();

        $keys = array_keys($request->except(['_token', 'name', 'code']));
        foreach ($keys as $key => $val) {
            $keys[$key] = str_replace('_', '.', $val);
        }

        Permission::all()->map(function ($permission) use ($keys, $role) {
            if (in_array($permission->code, $keys)) 
            {
                $permission->roles()->attach($role);
            }
        });

        DB::commit();

        return redirect(route('admin.role.update', ['id' => $role->id]))->with('success', 'Группа успешно создана');
    }
}
