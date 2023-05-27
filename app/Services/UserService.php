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

    public function saveUser($data){
        return $this->modelRepository->save($data->all());
    }
}