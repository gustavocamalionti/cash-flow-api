<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $modelRepository;

    public function __construct(
        UserRepository $modelRepository
    ) {
        $this->modelRepository = $modelRepository;
    }


    public function verifyDocumentType($document)
    {
        if (strlen($document) == 14) {
            return 'cnpj';
        } else {
            return 'cpf';
        }
    }
}
