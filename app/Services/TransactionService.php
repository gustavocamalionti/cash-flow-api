<?php

namespace App\Services;

use App\Repositories\TransactionRepository;

class TransactionServices extends BaseService
{
    protected $modelRepository;

    public function __construct(
        TransactionRepository $modelRepository
    ) {
        $this->modelRepository = $modelRepository;
    }
}
