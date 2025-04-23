<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email,'.$this->user()->id,
            'bio'=>'nullable|string|max:255',
            'url'=>'nullable|string|url',
            'username'=>'required|string|max:255'

        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException( response()->json([
            'status' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
