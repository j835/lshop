<?php

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->user()->can('page.update');
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
        if($this->code[0] != '/') {
            $this->code = '/' . $this->code;
            
        }

        return [
            'name' => 'max:200|required',
            'code' => 'page_code|max:200|required|unique:pages,code,' . $this->id . ',id',
            'seo_keywords' => 'max:255|nullable',
            'seo_description' => 'max:255|nullable',
            'content' => 'required'
        ];
    }
}
