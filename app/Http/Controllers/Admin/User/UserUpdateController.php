<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserUpdateController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;   
    }


    public function index($id, Request $request) 
    {
        $this->authorize('user.get');

        return view('admin.user.update',[
            'user' => User::with(['orders','role'])->find($id),
        ]);
    }


    public function update($id,UpdateUserRequest $request) 
    {
        $this->authorize('user.update');
        
        $user = User::find($id);      

        DB::beginTransaction();
        
        $user->update($request->validated());
        $user->update([
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        
        DB::commit();

        return back()->with('success', 'Данные пользователя успешно обновлены');
    } 

    public function login(Request $request)
    {
        $this->authorize('user.update');

        Auth::login(User::find($request->id), true);
        return redirect(route('admin.index'));
    }

    public function delete($id) 
    {
        $this->authorize('user.delete');

        $user = User::with('orders')->find($id);

        if($id === auth()->user()->id) {
            return back()->withErrors(['user_delete_error' =>'Ошибка: невозможно удалить текущего пользователя']);  
        }

        foreach($user->orders as $order) {
            if(!$order->is_cancelled) {
                return back()->withErrors(['user_delete_error' => 'Ошибка: невозможно удалить пользователя с активными заказами']);  
            }
        }

        $user->delete();

        return redirect(route('admin.user.select'))->with('success' , 'Пользователь успешно удален');
     }
}
