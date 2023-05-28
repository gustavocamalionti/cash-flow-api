<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    { 
        return [
            'balance' => 'required|numeric|min:1|max:2000'
        ];
    }

    public function messages(){
        return [
            'required' => 'The field is required.',
            'min' => 'The minimum value for this field is :max',
            'max' => 'The maximum value for this field is :max',
            'numeric'=> 'Only numbers are accepted for this field.'
        ];
    }
}
