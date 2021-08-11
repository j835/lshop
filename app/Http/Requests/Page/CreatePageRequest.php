<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->user()->can('page.create');
    }


    protected function prepareForValidation()
    {
        if ($this->code[0] != '/') {
            $this->merge(['code'=> '/'. $this->code]);
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
            'name' => 'max:200|required',
            'code' => 'page_code|max:200|required|unique:pages',
            'seo_keywords' => 'max:255|nullable',
            'seo_description' => 'max:255|nullable',
            'content' => 'required'
        ];
    }
}
