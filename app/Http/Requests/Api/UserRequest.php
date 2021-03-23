<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends ApiRequest
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
                    'email' => 'required|email|unique:users,email,NULL,id',
                    'role' => 'required',
                    'password' => 'required_with:password_confirmation|min:5',
                    'password_confirmation' => 'required_with:password|min:5|same:password'  
                ];
                break;
            case 'PUT':
                $id = $this->getSegmentFromEnd();
                if( is_numeric($id) )
                    $rules = [
                        'name' => 'required',
                        'email' => 'required|email|unique:users,email,'.$id.',id',
                        'role' => 'required',
                        'password' => ['nullable','required_with:password_confirmation', 'confirmed', 'min:5'],
                        'password_confirmation' => ['nullable','required_with:password','same:password', 'min:5'] 
                    ];
                break;
            default:break;
        }

        return $rules;
    }
}
