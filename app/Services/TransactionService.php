<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;

class TransactionService extends BaseService
{
    protected $modelRepository;
    protected $userRepository;

    public function __construct(
        TransactionRepository $modelRepository,
        UserRepository $userRepository
    ) {
        $this->modelRepository = $modelRepository;
        $this->userRepository = $userRepository;
    }

    public function verifyDocumentType($id)
    {
        $user = $this->userRepository->findById($id);
        if ($user == null or $user == "") {
            return null;
        }

        if (strlen($user->document) == 14) {
            return 'cnpj';
        } else {
            return 'cpf';
        }
    }

    public function getBalanceInAccount($id){
        $user = $this->userRepository->findById($id);
        if ($user == null or $user == "") {
            return 0;
        }
       return $user->balance;
    }
}
