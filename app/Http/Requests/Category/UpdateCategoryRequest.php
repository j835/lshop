<?php

namespace App\Http\Requests\Category;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('category.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            'name' => 'required|max:255',
            'code' => 'required|max:255|code|unique:catalog_categories,code,' . $this->id . ',id',
            'sort' => 'required|integer',
            'parent_id' => 'required|integer',
            'discount' => 'nullable|integer|between:0,100',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ];
    }


    public function withValidator($validator)
    {   
        if($this->parent_id) 
        {
            $validator->after(function($validator) {
                if(Product::withTrashed()->where('category_id', $this->parent_id)->count()) {
                    $validator->errors()->add('parent_id', 'В родительской категории не должно быть товаров');
                }
            });
        }
    }
}
