<?php

namespace App\Http\Requests\Product;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('product.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255|required',
            'code' => 'required|code|max:255|unique:catalog_products',
            'sort' => 'integer|min:1|required',
            'category_id' => 'integer|min:1|required',
            'price' => 'price|required',
            'discount' => 'nullable|integer|between:1,100',
            'new_price' => 'nullable|price',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ];
    }

    public function withValidator($validator)
    {
        if($this->category_id) 
        {
            $validator->after(function($validator) {
                if(Category::withTrashed()->find($this->category_id)->subcategories()->count()) {
                    return back()->withErrors(['category_id' => 'В категории не должно быть подкатегорий']);
                }
            });
        }
    }
}
