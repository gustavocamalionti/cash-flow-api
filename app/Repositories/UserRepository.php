<?php

namespace App\Repositories;

use App\Models\Users;

class UserRepository extends BaseRepository
{
    public function entity()
    {
        return Users::class;
    }
}