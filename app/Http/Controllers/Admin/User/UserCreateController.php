<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Hash;
use Illuminate\Http\Request;

class UserCreateController extends Controller
{

    public function index()
    {
        $this->authorize('user.get');

        return view('admin.user.create');
    }

    public function create(CreateUserRequest $request) 
    {
        $this->authorize('user.create');

        $user = new User($request->validated());
        $user->password = Hash::make($user->password);

        $user->save();

        return redirect( route('admin.user.update', ['id' => $user->id]))->with('success', 'Пользователь успешно создан');


    }
}
