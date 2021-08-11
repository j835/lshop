<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleSelectController extends Controller
{
    public function index() 
    {
        $this->authorize('user.role.get');

        return view('admin.role.select', [
            'roles' => Role::with('users')->get(),
        ]);
    }
}
