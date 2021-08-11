<?php

namespace App\Http\Requests\Order;

use App\Services\UserService;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Str;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Modify validation data 
     */
    public function validationData() {
        $password_raw = Str::random(rand(12, 14));

        $this->request->add([
            'phone' => app(UserService::class)->formatPhone($this->phone),
            'password_raw' => $password_raw,
            'password' => Hash::make($password_raw),
        ]);
        
        return $this->request->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        if(auth()->user()) {
            return [
              'message' => 'nullable|max:255',  
            ];
        }

        return [
            'name' => 'required|max:255|min:4',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|regex:/^8[0-9]{10}$/',
            'password' => 'required|max:255',
            'message' => 'nullable|max:255'
        ];
    }
}