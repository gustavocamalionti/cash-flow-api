<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
      $type_document = $this->documentType($this->request->all()['document']);
        return [
            'document' => 'required|unique:users|' . $type_document,
            'email' => 'required|unique:users',
            'balance' => 'required|numeric|min:1|max:2000'
        ];
    }

    public function messages(){
        return [
            'cpf' => 'Invalid CPF! Please try again.',
            'cnpj' => 'Invalid CNPJ! Please try again.',
            'document.unique' => 'This document already exists in the database!',
            'email.unique' => 'This email already exists in the database!',
            'min' => 'The minimum value for this field is :max',
            'max' => 'The maximum value for this field is :max',
            'decimal'=> 'Only numbers are accepted for this field.'
        ];
    }

    public function documentType($document){
        if (strlen($document) == 14) {
            return 'cnpj';
        } {
            return 'cpf';
        }  
    }
}
