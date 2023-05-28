<?php

namespace App\Http\Requests;

use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $type_document = $this->userService->verifyDocumentType($this->request->all()['document']);

        return [
            'document' => 'required|unique:users|' . $type_document,
            'email' => 'required|unique:users',
            'balance' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The field is required.',
            'cpf' => 'Invalid CPF! Please try again.',
            'cnpj' => 'Invalid CNPJ! Please try again.',
            'document.unique' => 'This document already exists in the database!',
            'email.unique' => 'This email already exists in the database!',
            'numeric' => 'Only numbers are accepted for this field.'
        ];
    }
}
