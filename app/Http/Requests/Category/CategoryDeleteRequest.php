<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CategoryDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('category.delete');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if (Product::withTrashed()->where('category_id', $this->id)->count()) {
                $validator->errors()->add('01','Нельзя удалить категорию с активными товарами');
            }
    
            if (Category::withTrashed()->where('parent_id', $this->id)->count()) {
                $validator->errors()->add('02', 'Нельзя удалить категорию с активными подкатегориями');
            }
        });
    }
}
