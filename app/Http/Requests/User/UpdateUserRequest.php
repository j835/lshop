<?php

namespace App\Http\Requests\User;

use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('user.create');
    }


    public function validationData() {

        $this->request->add([
            'phone' => app(UserService::class)->formatPhone($this->phone),
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
        return [
            'name' => 'required|max:255|min:4',
            'email' => 'required|email|max:255|unique:users,email,' . $this->id . ',id',
            'phone' => 'required|regex:/^8[0-9]{10}$/',
            'password' => 'confirmed|max:255',
            'role_id' => 'integer',
        ];
    }
}
