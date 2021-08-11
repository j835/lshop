<?php


namespace App\Services;

use App\Mail\UserRegister;
use App\Models\User;
use Mail;

class UserService
{
    public function formatPhone($phone) 
    {
        $phone = preg_replace('/^\+?7/', '8', $phone);
        $phone = preg_replace('/[^0-9]/','',$phone);
        return $phone;
    }

    public function search($query) 
    {
        $query = '%' .  trim($query) . '%';
        return User::where('name', 'like', $query)
            ->orWhere('email', 'like', $query)
            ->orWhere('phone', 'like', $query)->with('role');
    }

    public function sendRegisterEmail($email, $password) 
    {
        Mail::to(auth()->user()->email)->send(new UserRegister($email, $password));
    }
}
