<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUpdateController extends Controller
{

    public function index($id)
    {
        $this->authorize('user.role.get');

        return view('admin.role.update', [
            'role' => Role::with('permissions')->find($id),
        ]);
    }

    public function update($id, Request $request)
    {
        $this->authorize('user.role.update');

        $role = Role::find($id);
        $request->validate([
            'name' => 'required|max:150',
            'code' => 'code|required|max:150',
        ]);

        $keys = array_keys($request->except(['_token', 'name', 'code']));
        foreach ($keys as $key => $val) {
            $keys[$key] = str_replace('_', '.', $val);
        }

        DB::beginTransaction();

        $role->update($request->only(['name', 'code']));

        Permission::all()->map(function ($permission) use ($keys, $role) {
            if (in_array($permission->code, $keys)) {
                if (!$permission->roles->contains($role)) 
                {
                    $permission->roles()->attach($role);
                }
            } else {
                $permission->roles()->detach($role);
            }
        });

        DB::commit();

        return back()->with('success', 'Группа успешно обновлена');
    }

    public function delete($id) 
    {
        $this->authorize('user.role.delete');

        if(auth()->user()->role_id == $id) 
        {
            return back()->withErrors(['role_delete_error' => 'Ошибка: нельзя удалять группу текущего пользователя']);
        }

        DB::beginTransaction();

            User::where('role_id', '=', $id)->get()->map(function($user) {
                $user->update([
                    'role_id' => 0,
                ]);
            });

            Role::find($id)->delete();

        DB::commit();

        return redirect(route('admin.role.select'))->with('success' , 'Группа успешно удалена');

    }
}
