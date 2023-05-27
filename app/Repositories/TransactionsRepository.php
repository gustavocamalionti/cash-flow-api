<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepository extends BaseRepository
{
    public function entity()
    {
        return Transactions::class;
    }
}