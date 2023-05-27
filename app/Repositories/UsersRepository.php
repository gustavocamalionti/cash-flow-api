<?php

namespace App\Repositories;

use App\Models\Users;

class UsersRepository extends BaseRepository
{
    public function entity()
    {
        return Users::class;
    }
}