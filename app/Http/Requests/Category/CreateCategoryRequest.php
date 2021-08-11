<?php

namespace App\Http\Requests\Category;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('category.create');
    }

    /**
     * Modify validation data
     */
    public function validationData()
    {
        $parentCategory = Category::find($this->parent_id);

        if (!$parentCategory) {

            $this->request->add([
                'full_code' => $this->code,
                'level' => 0,
            ]);

            return $this->request->all();

        } else {
            $full_code = $parentCategory->full_code . '/' . $this->code;

            $this->request->add([
                'full_code' => $full_code,
                'level' => $parentCategory->level + 1,
            ]);

            return $this->request->all();
        }

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
            'code' => 'required|max:255|code|unique:catalog_categories',
            'sort' => 'required|integer',
            'parent_id' => 'required|integer',
            'full_code' => 'required',
            'level' => 'integer',
            'discount' => 'nullable|integer|between:1,100',
            'seo_description' => 'nullable|max:255',
            'seo_keywords' => 'nullable|max:255',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->parent_id) 
        {
            $validator->after(function ($validator) {
                if (Product::withTrashed()->where('category_id', $this->parent_id)->count()) {
                    $validator->errors()->add('parent_id', 'В родительской категории не должно быть товаров');
                }
            });
        }
    }
}
