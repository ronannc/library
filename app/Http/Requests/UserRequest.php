<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'     => 'required|max:120',
            'email'    => 'required|email|max:120|unique:users',
            'password' => 'required|min:6|max:120|confirmed',
        ];
    }
    
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException(
            response()->json( [
                                  'success' => false,
                                  'message' => 'Validation errors',
                                  'data'    => $validator->errors()
                              ], 400 )
        );
    }
}
