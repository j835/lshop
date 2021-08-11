<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;

class UserSelectController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;   
    }

    public function index(Request $request) 
    {   
        $this->authorize('user.get');
        
        $users = User::with('role');

        if($request->q) {
            $users = $this->userService->search($request->q);
        }
        if($request->role_id) {
            $users = $users->where('role_id', '=', $request->role_id);
        }

        return view('admin.user.select', [
            'users' => $users->paginate(50),
        ]);
    }
}
