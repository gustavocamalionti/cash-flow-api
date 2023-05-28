<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionsController extends Controller
{
    protected $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function makeTransaction(TransactionsRequest $request){
        dd($request->all());
    }

}
