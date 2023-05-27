<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionRepository extends BaseRepository
{
    public function entity()
    {
        return Transactions::class;
    }
}