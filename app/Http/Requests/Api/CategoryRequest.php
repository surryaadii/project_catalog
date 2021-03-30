<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends ApiRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch ($this->method()) {
            case 'POST':
                foreach (config('translatable.locales') as $locale) {
                    $rules[$locale . '_name'] = 'required';
                    $rules[$locale . '_description'] = 'required';
                }
                break;
            case 'PUT':
                $id = $this->getSegmentFromEnd();
                if( is_numeric($id) )
                    foreach (config('translatable.locales') as $locale) {
                        $rules[$locale . '_name'] = 'required';
                        $rules[$locale . '_description'] = 'required';
                        $rules[$locale . '_sub_category_name.*'] = 'filled|max:255';
                    }
                break;
            default:break;
        }
        return $rules;
    }
}
