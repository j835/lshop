<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    public function __construct() {
        $this->middleware(['guest']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if(!config('app.debug')) {
            $request->validate(['g-recaptcha-response' => 'recaptcha']);
        }

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,])) {
            return redirect()->route('profile.index');
        } else {
            return back()->withErrors(['login_error' => 'Неверный логин или пароль']);
        }

    }

    public function logout()
    {
        Auth::logout();
        return back();
    }


}
