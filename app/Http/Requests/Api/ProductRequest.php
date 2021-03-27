<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends ApiRequest
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
                $rules = [
                    'name' => 'required',
                    'description' => 'required',
                    'category_id' => 'required'
                ];
                break;
            case 'PUT':
                $id = $this->getSegmentFromEnd();
                if( is_numeric($id) )
                    $rules = [
                        'name' => 'required',
                        'description' => 'required',
                        'category_id' => 'required'
                    ];
                break;
            default:break;
        }
        return $rules;
    }
}
