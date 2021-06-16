<?php


namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserService
{
    public function orderRegister(Request $request)
    {
        $request->merge([
            'phone' => $this->formatPhone($request->phone),
            'password' => $this->generatePassword(),
        ]);

        $request->validate([
            'name' => 'required|max:255|min:4',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|regex:/^8[0-9]{10}$/',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], true);

        return $user->getAttribute('id');
    }

    public function updateUserInfo(Request $request) {
        $request->validate([
            'name' => 'required|max:255|min:4',
            'phone' => 'required|regex:/^8[0-9]{10}$/',
        ]);

        if($request->email !== Auth::user()->email) {
            $request->validate([
                'email' => 'required|email|max:255|unique:users',
            ]);
        }

        Auth::user()->update($request->only('name', 'email', 'phone'));

    }

    private function formatPhone($phone) {
        $phone = preg_replace('/^\+?7/', '8', $phone);
        $phone = preg_replace('/[^0-9]/','',$phone);
        return $phone;
    }

    private function generatePassword() {
        return Str::random(rand(12, 14));
    }



}
