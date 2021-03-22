<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
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
        return [];
    }

     /**
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator)
    {
        $sTime = microtime(true);
        $status = true;

        return $validator->errors()->all();
       /* return response()->json([
            'status' => $status,
            'message' => 'Complete',
            'values' => [
                //'error'=>$validator->errors()->all(),
            ],
            'time' => microtime(true)-$sTime
        ]);*/
    }


    public function validator(){

        $v = \Validator::make($this->input(), $this->rules(), $this->messages(), $this->attributes());

        //if( $this->input('loginValidator') ) {
            if (method_exists($this, 'loginValidator'))
                $this->loginValidator($v);
        //}

        //if( $this->input('forgetValidator') ) {
            if (method_exists($this, 'forgetValidator'))
                $this->forgetValidator($v);
        //}

        //if( $this->input('updateProfileValidator') ) {
            if (method_exists($this, 'updateProfileValidator'))
                $this->updateProfileValidator($v);
        //}

        return $v;
    }
}
