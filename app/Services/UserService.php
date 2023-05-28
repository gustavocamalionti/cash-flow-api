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

    public function saveUser($data)
    {
        return $this->modelRepository->save($data->all());
    }

    public function findUser($id)
    {
        return $this->modelRepository->findById($id);
    }

    public function updateUser($data, $id)
    {
        return $this->modelRepository->update($id, $data->all(), true);
    }

    public function deleteUser($id)
    {
        return $this->modelRepository->delete($id);
    }
}
