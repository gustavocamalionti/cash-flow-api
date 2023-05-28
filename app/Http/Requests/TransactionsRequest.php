<?php

namespace App\Http\Requests;

use App\Services\TransactionService;
use Illuminate\Foundation\Http\FormRequest;

class TransactionsRequest extends FormRequest
{
    protected $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
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
        $type_document = $this->transactionService->verifyDocumentType($this->request->all()['send_user_id']);
        $max_transfer = $this->transactionService->getBalanceInAccount($this->request->all()['send_user_id']);
        
        switch ($type_document) {
            case null:
                //Error return: will definitely get the error does not user exist.
                return [
                    'send_user_id' => 'required|integer|exists:users,id',
                    'receiver_user_id' => 'required|integer|exists:users,id',
                    'amount' => 'required|numeric|min:0.01|max:' . $max_transfer
                ];

            case 'cnpj':
                return [
                    'send_user_id' => 'required|integer|exists:users,id|not_in:' . $this->request->all()['send_user_id'],
                    'receiver_user_id' => 'required|integer|exists:users,id|not_in:' . $this->request->all()['send_user_id'],
                    'amount' => 'required|numeric|min:0.01|max:' . $max_transfer
                ];
            
            case 'cpf':
                return [
                    'send_user_id' => 'required|integer|exists:users,id',
                    'receiver_user_id' => 'required|integer|exists:users,id|not_in:' . $this->request->all()['send_user_id'],
                    'amount' => 'required|numeric|min:0.01|max:' . $max_transfer
                ];   
        }
    }

    public function messages()
    {
        return [
            'required' => 'The field is required.',
            'exists' => 'User not found.',
            'receiver_user_id.not_in' => 'You cant transfer to yourself.',
            'send_user_id.not_in' => 'It isnt possible to make the transfer, your account is a merchant type.',
            'numeric' => 'Only numbers are accepted for this field.',
            'min' => 'Minimum allowed value of R$ :min',
            'max' => 'Maximum allowed value of R$ :max',
        ];
    }
}
