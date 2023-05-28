<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use Illuminate\Database\QueryException;
use App\Http\Requests\TransactionsRequest;

class TransactionsController extends Controller
{
    protected $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function makeTransaction(TransactionsRequest $request)
    {
        try {
            
            $response = $this->transactionService->addTransactionJobToQueue($request->all());
            

            return response()->json([
                'msg' => $response
            ], 200);

        } catch (QueryException $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Erro',
                'data' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }
}
